<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MasterAdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! master_admin_requires_login()) {
            return $next($request);
        }

        if (Auth::guard('admin')->check() && Auth::guard('admin')->id() === 1) {
            return $next($request);
        }

        return redirect()->route('master-admin.auth');
    }
}
