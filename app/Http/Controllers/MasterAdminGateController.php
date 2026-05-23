<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterAdminGateController extends Controller
{
    public function showForm()
    {
        if (! master_admin_requires_login()) {
            return redirect()->route('master-admin.dashboard');
        }

        if (Auth::guard('admin')->check() && Auth::guard('admin')->id() === 1) {
            return redirect()->route('master-admin.dashboard');
        }

        return view('errors.master-admin-auth');
    }

    public function authenticate(Request $request)
    {
        if (! master_admin_requires_login()) {
            return redirect()->route('master-admin.dashboard');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (! $admin) {
            return back()->withErrors([
                'email' => 'Email không tồn tại trong hệ thống.',
            ])->onlyInput('email');
        }

        if (! $admin->is_active) {
            return back()->withErrors([
                'email' => 'Tài khoản đã bị vô hiệu hóa.',
            ])->onlyInput('email');
        }

        if (! Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return back()->withErrors([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (Auth::guard('admin')->id() !== 1) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Chỉ super admin (ID=1) mới có thể truy cập Master Admin.',
            ])->onlyInput('email');
        }

        return redirect()->route('master-admin.dashboard');
    }
}
