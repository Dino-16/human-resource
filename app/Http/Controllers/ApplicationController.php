<?php

namespace App\Http\Controllers;

use App\Models\Recruitment\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function viewResume($id)
    {
        $application = Application::findOrFail($id);
        
        // Extract the file path from the URL
        // URL format: http://localhost/storage/resumes/filename.pdf
        // We need just: resumes/filename.pdf
        $url = $application->applicant_resume_file;
        
        // Parse the URL to get the file path
        $path = parse_url($url, PHP_URL_PATH);
        $relativePath = str_replace('/storage/', '', $path);
        
        // Return the file from storage
        return response()->file(storage_path('app/public/' . $relativePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }
}
