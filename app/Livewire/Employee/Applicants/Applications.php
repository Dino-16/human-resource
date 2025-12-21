<?php

namespace App\Livewire\Employee\Applicants;

use Livewire\Component;
use App\Models\Recruitment\Application;
use App\Services\ResumeParser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Applications extends Component
{
    public function render()
    {
        $applicants = Application::latest()->paginate(10);
        return view('livewire.employee.applicants.applications', compact('applicants'));
    }

    public function reviewResume($id)
    {
        $application = Application::findOrFail($id);
        $this->processApplicationResume($application, false);
    }

    public function filterWithAI($id)
    {
        $application = Application::findOrFail($id);
        $this->processApplicationResume($application, true);
    }

    protected function processApplicationResume(Application $application, bool $forceOpenAI = false)
    {
        DB::beginTransaction();
        try {
            // Resolve stored resume path using public disk
            $stored = $application->applicant_resume_file;
            $relative = null;
            $fullPath = null;

            if (filter_var($stored, FILTER_VALIDATE_URL)) {
                $urlPath = parse_url($stored, PHP_URL_PATH) ?: '';
                $relative = ltrim($urlPath, '/'); // e.g. storage/resumes/filename.pdf
                if (strpos($relative, 'storage/') === 0) {
                    $relative = substr($relative, strlen('storage/')); // resumes/filename.pdf
                }
            } else {
                $relative = ltrim($stored, '/');
                if (strpos($relative, 'storage/') === 0) {
                    $relative = substr($relative, strlen('storage/'));
                }
            }

            // Resolve to absolute path
            if ($relative && Storage::disk('public')->exists($relative)) {
                $fullPath = Storage::disk('public')->path($relative);
            }

            $parser = app(ResumeParser::class);
            $extracted = ['skills' => null, 'education' => null, 'experience' => null];
            $usedOpenAI = false;

            if ($fullPath && file_exists($fullPath)) {
                // Local extraction
                $local = $parser->extractLocally($fullPath);
                Log::info('Resume local extraction', [
                    'application_id' => $application->id,
                    'file_path' => $fullPath,
                    'raw_length' => strlen($local['__raw_text'] ?? ''),
                    'ext' => $local['__source_ext'] ?? null,
                ]);

                $normalized = $parser->normalize($local);

                // Optional AI refinement
                $aiResult = null;
                $rawText = $local['__raw_text'] ?? null;
                if (!empty($rawText) && (env('OPENAI_API_KEY') || env('OPENAI_KEY'))) {
                    $aiResult = $parser->extractWithOpenAIFromText($rawText);
                    $usedOpenAI = !empty($aiResult);
                    Log::info('AI extraction attempted', [
                        'application_id' => $application->id,
                        'ai_result' => !empty($aiResult),
                    ]);
                }

                // merge rule: AI overrides local only if not empty (or forced)
                foreach (['skills','education','experience'] as $k) {
                    $valLocal = $normalized[$k] ?? null;
                    $valAi = $aiResult[$k] ?? null;
                    $final = $valLocal;
                    if ($forceOpenAI) {
                        if (!empty($valAi)) {
                            $final = $valAi;
                        }
                    } else {
                        if (!empty($valAi)) {
                            $final = $valAi;
                        }
                    }
                    $extracted[$k] = $final;
                }

                // Diagnostic check
                $allEmpty = true;
                foreach ($extracted as $v) { if (!empty($v)) { $allEmpty = false; break; } }
                if ($allEmpty) {
                    Log::warning('Resume parsing produced no fields', [
                        'application_id' => $application->id,
                        'parser' => $local['__parser'] ?? 'local',
                        'ext' => $local['__source_ext'] ?? null,
                        'raw_length' => isset($local['__raw_text']) ? strlen($local['__raw_text']) : 0,
                        'openai_used' => $usedOpenAI,
                        'forceOpenAI' => $forceOpenAI,
                    ]);
                }

                // Normalize arrays to strings
                foreach (['skills','education','experience'] as $k) {
                    if (isset($extracted[$k]) && is_array($extracted[$k])) {
                        $extracted[$k] = implode(', ', $extracted[$k]);
                    }
                    if ($extracted[$k] === '') $extracted[$k] = null;
                }

                // Insert or update filtered_resumes table
                $now = now();
                $payload = [
                    'application_id' => $application->id,
                    'skills' => $extracted['skills'] ?? null,
                    'education' => $extracted['education'] ?? null,
                    'experience' => $extracted['experience'] ?? null,
                    'updated_at' => $now,
                ];

                $exists = DB::table('filtered_resumes')->where('application_id', $application->id)->first();
                if ($exists) {
                    DB::table('filtered_resumes')->where('id', $exists->id)->update($payload);
                } else {
                    $payload['created_at'] = $now;
                    DB::table('filtered_resumes')->insert($payload);
                }

            } else {
                Log::warning('Resume file not found', [
                    'application_id' => $application->id,
                    'stored_url' => $stored,
                    'relative_path' => $relative,
                    'full_path' => $fullPath,
                ]);
            }

            // Mark application as Filtered
            $application->status = 'Filtered';
            $application->save();

            DB::commit();

            session()->flash('success', 'Resume reviewed and filtered successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to parse or save filtered resume: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to filter resume. Check logs for details.');
        }
    }
}
