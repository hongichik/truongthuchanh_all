<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DangKyLop6 extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'birthdate',
        'gender',
        'ethnicity',
        'current_school',
        'citizen_id',
        'address',
        'birthplace',
        'phone',
        'father_name',
        'father_ethnicity',
        'father_birthyear',
        'father_occupation',
        'mother_name',
        'mother_ethnicity',
        'mother_birthyear',
        'mother_occupation',
        'guardian_name',
        'guardian_birthyear',
        'guardian_occupation',
        'grade1_academic',
        'grade1_conduct',
        'grade2_academic',
        'grade2_conduct',
        'grade3_academic',
        'grade3_conduct',
        'grade4_academic',
        'grade4_conduct',
        'grade5_academic',
        'grade5_conduct',
        'grade5_math_avg',
        'grade5_literature_avg',
        'status',
        'notes',
        'is_disabled',
        'achievements',
        'achievement_rank',
        'academic_transcript_path',
        'additional_documents_paths',
        'documents_uploaded_at'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'academic_transcript_path' => 'array',
        'additional_documents_paths' => 'array',
        'documents_uploaded_at' => 'datetime'
    ];
}
