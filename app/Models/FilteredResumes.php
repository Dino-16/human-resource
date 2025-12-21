<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilteredResumes extends Model
{
    protected $table = 'filtered_resumes';

    protected $fillable = [
        'application_id',
        'skills',
        'education',
        'experience',
    ];

    public function application()
    {
        return $this->belongsTo(\App\Models\Recruitment\Application::class, 'application_id');
    }
}
