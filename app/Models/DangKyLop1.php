<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DangKyLop1 extends Model
{
    use HasFactory;

    protected $table = 'dang_ky_lop1s';
    
    protected $fillable = [
        'fullname',
        'birthdate',
        'gender',
        'ethnicity',
        'birthplace',
        'citizen_id',
        'address',
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
        'guardian_phone',
        'is_disabled',
        'achievements',
        'achievement_rank',
        'registration_form_path',
        'registration_form_uploaded_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'registration_form_uploaded_at' => 'datetime',
    ];
}
