<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterAdminController extends Controller
{
    /**
     * Show Master Admin password generator page
     */
    public function passwordGenerator()
    {
        $today = now();
        $todayPassword = generate_master_admin_password();
        
        // Generate passwords for next 7 days
        $passwords = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $dateString = $date->format('d/m/Y');
            $password = generate_master_admin_password($dateString);
            
            $passwords[] = [
                'date' => $dateString,
                'day_name' => $date->isoFormat('dddd'),
                'password' => $password,
                'url' => get_master_admin_url('', $dateString),
                'logs_url' => get_master_admin_url('logs/view', $dateString),
                'is_today' => $i === 0
            ];
        }
        
        return view('admin.master-admin.password', compact('passwords', 'todayPassword'));
    }
}