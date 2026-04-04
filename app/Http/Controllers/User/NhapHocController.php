<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DangKyLop1;
use App\Models\DangKyLop6;
use App\Models\DangKyLop10;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NhapHocController extends Controller
{
    /**
     * Hiển thị form đăng ký lớp 1
     */
    public function dangKyLop1()
    {
        return view('user.nhap-hoc.dang-ky-lop-1');
    }
    
    /**
     * Xử lý đăng ký lớp 1
     */
    public function storeLop1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'gender' => 'required|in:Nam,Nữ',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'guardian_name' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('\\n', $errors);
            return back()->withInput()->with('error_alert', $errorMessage);
        }
        
        try {
            DangKyLop1::create($request->all());
            return back()->with('success_alert', 'Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error_alert', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.');
        }
    }
    
    /**
     * Hiển thị form đăng ký lớp 6
     */
    public function dangKyLop6()
    {
        return view('user.nhap-hoc.dang-ky-lop-6');
    }
    
    /**
     * Xử lý đăng ký lớp 6
     */
    public function storeLop6(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'gender' => 'required|in:Nam,Nữ',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'guardian_name' => 'required|string|max:255',
            'current_school' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('\\n', $errors);
            return back()->withInput()->with('error_alert', $errorMessage);
        }
        
        try {
            DangKyLop6::create($request->all());
            return back()->with('success_alert', 'Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error_alert', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.');
        }
    }
    
    /**
     * Hiển thị form đăng ký lớp 10
     */
    public function dangKyLop10()
    {
        return view('user.nhap-hoc.dang-ky-lop-10');
    }
    
    /**
     * Xử lý đăng ký lớp 10
     */
    public function storeLop10(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'gender' => 'required|in:Nam,Nữ',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'current_school' => 'required|string|max:255',
            'grade9_math_avg' => 'nullable|numeric|min:0|max:10',
            'grade9_literature_avg' => 'nullable|numeric|min:0|max:10',
            'special_info' => 'nullable|string|max:1000',
            'is_disabled' => 'nullable|in:Không,Có',
            'achievements' => 'nullable|string|max:500',
            'achievement_rank' => 'nullable|string|max:100',
            'is_policy_family' => 'nullable|in:Không,Có'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('\\n', $errors);
            return back()->withInput()->with('error_alert', $errorMessage);
        }
        
        try {
            DangKyLop10::create($request->all());
            return back()->with('success_alert', 'Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error_alert', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.');
        }
    }
}
