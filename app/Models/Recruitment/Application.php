<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'applied_position',
        'applicant_last_name',
        'applicant_first_name',
        'applicant_middle_name',
        'applicant_suffix_name',
        'applicant_address',
        'applicant_email',
        'applicant_phone',
        'applicant_resume_file',
        'status',
        'agreed_to_terms',
    ];
}
