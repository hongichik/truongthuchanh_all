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
