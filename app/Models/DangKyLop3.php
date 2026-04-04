<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DangKyLop3 extends Model
{
    use HasFactory;

    protected $table = 'dang_ky_lop3s';
    
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
