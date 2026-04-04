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
        'citizen_id',
        'address',
        'phone',
        'guardian_name',
        'guardian_phone',
        'status',
        'notes'
    ];

    protected $casts = [
        'birthdate' => 'date'
    ];
}
