<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasterAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Generate daily password
        $dailyPassword = $this->generateDailyPassword();
        
        // Check if password is provided and correct
        $providedPassword = $request->query('pass');
        
        if ($providedPassword !== $dailyPassword) {
            // Return unauthorized response with password hint
            $message = "Access denied. Daily password required.";
            
            if (app()->environment('local')) {
                $message .= " Today's password: " . $dailyPassword;
            }
            
            return response()->view('errors.master-admin-auth', [
                'message' => $message,
                'date' => now()->format('d/m/Y')
            ], 401);
        }

        return $next($request);
    }

    /**
     * Generate daily password using MD5 hash
     * Format: hong + day/month/year (e.g., hong3/5/2026)
     */
    private function generateDailyPassword(): string
    {
        $today = now();
        $dateString = 'hong' . $today->day . '/' . $today->month . '/' . $today->year;
        
        return md5($dateString);
    }
}