<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanEditHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth()->guard('admin')->user();
        
        // Kiểm tra admin đã đăng nhập
        if (!$admin) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thực hiện hành động này.'
                ], 401);
            }
            
            return redirect()->route('admin.login')->with('error_alert', 'Bạn cần đăng nhập để truy cập trang này.');
        }

        // Kiểm tra quyền: admin có id = 0 hoặc có quyền edit-home
        if ($admin->id == 0 || $admin->hasPermission('edit-home')) {
            return $next($request);
        }
        
        // Không có quyền
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này.'
            ], 403);
        }
        
        return redirect()->back()->with('error_alert', 'Bạn không có quyền truy cập chức năng này.');
    }
}