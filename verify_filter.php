<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$kernel->bootstrap();

$filtered = \App\Models\FilteredResumes::where('application_id', 1)->first();
$application = \App\Models\Recruitment\Application::find(1);

echo "=== FILTER BUTTON TEST RESULTS ===\n";
echo "Application ID: " . $application->id . "\n";
echo "Application Status: " . $application->status . "\n";
echo "Filtered Resume Created: " . ($filtered ? "YES" : "NO") . "\n";
if ($filtered) {
    echo "Skills Extracted: " . (strlen($filtered->skills ?? '') > 0 ? "YES (" . strlen($filtered->skills) . " chars)" : "NO") . "\n";
    echo "Education Extracted: " . (strlen($filtered->education ?? '') > 0 ? "YES (" . strlen($filtered->education) . " chars)" : "NO") . "\n";
    echo "Experience Extracted: " . (strlen($filtered->experience ?? '') > 0 ? "YES (" . strlen($filtered->experience) . " chars)" : "NO") . "\n";
}
