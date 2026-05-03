<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DangKyLop10 extends Model
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
        'phone',
        'father_name',
        'father_ethnicity',
        'mother_name',
        'mother_ethnicity',
        'grade6_academic',
        'grade6_conduct',
        'grade7_academic',
        'grade7_conduct',
        'grade8_academic',
        'grade8_conduct',
        'grade9_academic',
        'grade9_conduct',
        'grade9_math_avg',
        'grade9_literature_avg',
        'status',
        'notes',
        'special_info',
        'is_disabled',
        'achievements',
        'achievement_rank',
        'is_policy_family',
        'academic_transcript_path',
        'additional_documents_paths',
        'documents_uploaded_at'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'academic_transcript_path' => 'array', // Now stores multiple files
        'additional_documents_paths' => 'array',
        'documents_uploaded_at' => 'datetime'
    ];
}
