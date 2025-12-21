<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ResumeParser
{
    public function extractWithOpenAIFromText(string $text): array
    {
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return [];
        }

        $prompt = <<<PROMPT
You are an expert resume parser. STRICTLY FOLLOW:
1) Read the resume text below.
2) Extract these fields. If unknown, set to null.
3) Return ONLY compact JSON (one line). Do not include explanations.
FIELDS:
{
  "first_name": string | null,
  "middle_name": string | null,
  "last_name": string | null,
  "suffix": string | null,
  "address": string | null,
  "education": string | null,    // short summary; school, degree, year(s)
  "skills": string | null,       // comma-separated list of skills only
  "experience": string | null    // 1-3 sentence summary of relevant experience
}
RESUME TEXT:
---
$text
---
PROMPT;

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4o-mini',
                'input' => [[
                    'role' => 'user',
                    'content' => [ ['type' => 'input_text', 'text' => $prompt] ],
                ]],
                'max_output_tokens' => 800,
            ]);

        if (!$response->successful()) {
            return [];
        }

        $textOut = $response->json('output_text');
        if (!$textOut) {
            return [];
        }
        $data = json_decode($textOut, true);
        if (!is_array($data)) {
            if (preg_match('/\{.*\}/s', (string) $textOut, $m)) {
                $data = json_decode($m[0], true);
            }
        }
        return is_array($data) ? $data : [];
    }

    public function extractLocally(string $filePath): array
    {
        $text = '';
        try {
            if (class_exists('Smalot\\PdfParser\\Parser')) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();
            }
        } catch (\Throwable $e) {
            // ignore, fallback to empty text
        }

        $sections = $this->parseSectionsFromText($text);
        $sections['__raw_text'] = $text;
        $sections['__parser'] = class_exists('Smalot\\PdfParser\\Parser') ? 'smalot' : 'none';
        $sections['__source_ext'] = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return $sections;
    }

    public function normalize(array $extracted): array
    {
        $out = $extracted;
        $clean = function($v) {
            if ($v === null) return null;
            $v = is_array($v) ? implode(', ', $v) : (string) $v;
            $v = trim(preg_replace('/\s+/', ' ', $v));
            if ($v === '' || strtolower($v) === 'null') return null;
            return $v;
        };

        foreach (['first_name','middle_name','last_name','suffix','address','education','skills','experience'] as $k) {
            $out[$k] = array_key_exists($k, $out) ? $clean($out[$k]) : null;
        }

        $raw = isset($out['__raw_text']) ? (string)$out['__raw_text'] : '';

        $out['skills'] = $this->cleanSkillsString($out['skills'] ?? '', $raw);
        $out['experience'] = $this->cleanExperienceString($out['experience'] ?? '', $raw);
        $out['education'] = $this->cleanEducationString($out['education'] ?? '', $raw);

        foreach (['education','experience','skills','address'] as $k) {
            if (!empty($out[$k]) && strlen($out[$k]) > 2000) {
                $out[$k] = substr($out[$k], 0, 2000);
            }
        }

        return $out;
    }

    private function cleanSkillsString(string $skills, string $raw): string
    {
        $source = $skills ?: $raw;
        if ($source === '') return '';

        $parts = preg_split('/[\n,;•\-\x{2022}]+/u', $source);
        $ban = [
            'about me','about-me','profile','objective','summary','personal information','personal info','contact','contacts',
            'age','birthday','birthdate','b-day','bday','gender','sex','civil status','nationality','religion',
            'height','weight','cm','kg','lbs','blood type','address','email','phone','mobile','contact number','facebook','linkedin','github',
            'experience','work experience','employment','education','elementary','high school','senior high','university','college','institute','school'
        ];
        $out = [];
        foreach ($parts as $p) {
            $t = trim($p);
            if ($t === '') continue;
            $low = mb_strtolower($t);
            $reject = false;
            foreach ($ban as $b) { if (str_contains($low, $b)) { $reject = true; break; } }
            if ($reject) continue;
            if (preg_match('/(\d{2,}\s*(cm|kg|lbs))|\b(\d{2,})\b/i', $t)) continue;
            if (mb_strlen($t) > 40) continue;
            $words = preg_split('/\s+/', $t);
            if (count($words) > 6) continue;
            $t = trim(preg_replace('/\s+/', ' ', $t));
            $t = trim($t, ". •-\t");
            if ($t === '') continue;
            $out[] = ucfirst($t);
        }
        $whitelist = [
            'communication','teamwork','leadership','time management','problem solving','adaptability','creativity','critical thinking','attention to detail','customer service','multitasking','collaboration','interpersonal',
            'microsoft office','excel','word','powerpoint','outlook','google sheets','google docs','sql','database','javascript','php','laravel','react','vue','html','css','git','docker',
            'photoshop','illustrator','video editing','content creation','social media management','canva','figma','data entry','typing','bookkeeping','accounting','sales','marketing'
        ];
        $mined = [];
        $rawLower = mb_strtolower($raw);
        foreach ($whitelist as $kw) {
            if ($kw === '') continue;
            if (mb_strpos($rawLower, $kw) !== false) {
                $mined[] = ucwords($kw);
            }
        }

        $out = array_values(array_unique(array_merge($out, $mined)));
        $uniq = [];
        foreach ($out as $s) {
            $s = preg_replace('/\s+/', ' ', trim($s));
            if ($s === '') continue;
            if (mb_strlen($s) > 35) continue;
            $uniq[strtolower($s)] = $s;
        }
        $out = array_values($uniq);
        if (count($out) > 0) {
            return implode(', ', array_slice($out, 0, 20));
        }
        return '';
    }

    private function cleanExperienceString(string $exp, string $raw): ?string
    {
        $s = trim($exp ?: '');
        if ($s === '' && $raw !== '') {
            if (preg_match('/(?:(?:\d+\+?)\s*(?:years?|yrs?)\s+of\s+)?(?:work\s+)?experience[^\.!?]*[\.!?]/i', $raw, $m)) {
                $s = trim($m[0]);
            }
        }
        if ($s === '') return null;
        $s = preg_replace('/\s+/', ' ', $s);
        $sentences = preg_split('/(?<=[\.!?])\s+/', $s);
        $s = implode(' ', array_slice($sentences, 0, 2));
        return $s;
    }

    private function cleanEducationString(string $edu, string $raw): ?string
    {
        $s = trim($edu ?: '');
        $src = $s ?: $raw;
        if ($src === '') return null;
        $lines = preg_split('/[\n\r]+/', $src);
        $keep = [];
        foreach ($lines as $line) {
            $t = trim($line);
            if ($t === '') continue;
            $low = mb_strtolower($t);
            if (str_contains($low, 'skills')) continue;
            if (
                preg_match('/\b(university|college|school|institute|bachelor|master|bs\.?|ba\.?|bsc\.?|msc\.?|degree)\b/i', $t) ||
                preg_match('/\b20\d{2}\b/', $t)
            ) {
                $keep[] = $t;
            }
        }
        $keep = array_values(array_unique($keep));
        if (empty($keep)) return $s ?: null;
        $out = implode('; ', array_slice($keep, 0, 5));
        $out = preg_replace('/\s+/', ' ', $out);
        return $out;
    }

    public function parseSectionsFromText(?string $text): array
    {
        $text = $text ? preg_replace("/[\t\r]+/", ' ', $text) : '';
        $text = preg_replace("/ +/", ' ', $text);

        $lower = mb_strtolower($text);
        $map = [
            'skills' => ['skills', 'skill set'],
            'experience' => ['experience', 'work experience', 'employment history'],
            'education' => ['education', 'educational background', 'academic background'],
        ];

        $out = ['skills'=>'', 'experience'=>'', 'education'=>''];
        if (!$text) return $out;

        $positions = [];
        foreach ($map as $key => $keywords) {
            $pos = -1;
            foreach ($keywords as $kw) {
                $p = mb_strpos($lower, $kw);
                if ($p !== false && ($pos === -1 || $p < $pos)) { $pos = $p; }
            }
            if ($pos !== -1) { $positions[$key] = $pos; }
        }

        asort($positions);
        $keys = array_keys($positions);
        for ($i=0; $i<count($keys); $i++) {
            $key = $keys[$i];
            $start = $positions[$key];
            $end = ($i+1<count($keys)) ? $positions[$keys[$i+1]] : mb_strlen($text);
            $chunk = trim(mb_substr($text, $start, $end - $start));
            $chunk = preg_replace('/^\s*([A-Za-z ]{3,20}):?/u', '', $chunk);
            $out[$key] = trim($chunk);
        }

        foreach (['skills','experience','education'] as $k) {
            if (mb_strlen($out[$k]) > 4000) {
                $out[$k] = mb_substr($out[$k], 0, 4000);
            }
        }
        return $out;
    }
}
