<?php

if (!function_exists('generate_master_admin_password')) {
    /**
     * Generate daily password for Master Admin
     * 
     * @param string|null $date Date in format d/m/Y, defaults to today
     * @return string MD5 hash password
     */
    function generate_master_admin_password($date = null): string
    {
        if ($date) {
            try {
                $dateObj = \Carbon\Carbon::createFromFormat('d/m/Y', $date);
            } catch (\Exception $e) {
                $dateObj = now();
            }
        } else {
            $dateObj = now();
        }
        
        $dateString = 'hong' . $dateObj->day . '/' . $dateObj->month . '/' . $dateObj->year;
        return md5($dateString);
    }
}

if (!function_exists('get_master_admin_url')) {
    /**
     * Get Master Admin URL with today's password
     * 
     * @param string $path Path within master-admin
     * @param string|null $date Date for password generation
     * @return string Complete URL with password
     */
    function get_master_admin_url($path = '', $date = null): string
    {
        $password = generate_master_admin_password($date);
        $baseUrl = config('app.url') . '/master-admin';
        
        if ($path) {
            $baseUrl .= '/' . ltrim($path, '/');
        }
        
        return $baseUrl . '?pass=' . $password;
    }
}