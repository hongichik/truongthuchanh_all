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
            'ethnicity' => 'nullable|string|max:255',
            'birthplace' => 'nullable|string|max:255',
            'citizen_id' => 'nullable|string|max:50',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'father_name' => 'nullable|string|max:255|required_without_all:mother_name,guardian_name',
            'father_ethnicity' => 'nullable|string|max:255',
            'father_birthyear' => 'nullable|integer|min:1920|max:2010',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255|required_without_all:father_name,guardian_name',
            'mother_ethnicity' => 'nullable|string|max:255',
            'mother_birthyear' => 'nullable|integer|min:1920|max:2010',
            'mother_occupation' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255|required_without_all:father_name,mother_name',
            'guardian_birthyear' => 'nullable|integer|min:1920|max:2010',
            'guardian_occupation' => 'nullable|string|max:255',
            'is_disabled' => 'nullable|string|max:500',
            'achievements' => 'nullable|string|max:500',
            'achievement_rank' => 'nullable|string|max:100'
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
            'ethnicity' => 'nullable|string|max:255',
            'birthplace' => 'nullable|string|max:255',
            'current_school' => 'required|string|max:255',
            'citizen_id' => 'nullable|string|max:50',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'father_ethnicity' => 'nullable|string|max:255',
            'father_birthyear' => 'nullable|integer|min:1920|max:2010',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_ethnicity' => 'nullable|string|max:255',
            'mother_birthyear' => 'nullable|integer|min:1920|max:2010',
            'mother_occupation' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birthyear' => 'nullable|integer|min:1920|max:2010',
            'guardian_occupation' => 'nullable|string|max:255',
            'grade1_academic' => 'nullable|string',
            'grade1_conduct' => 'nullable|string',
            'grade2_academic' => 'nullable|string',
            'grade2_conduct' => 'nullable|string',
            'grade3_academic' => 'nullable|string',
            'grade3_conduct' => 'nullable|string',
            'grade4_academic' => 'nullable|string',
            'grade4_conduct' => 'nullable|string',
            'grade5_academic' => 'nullable|string',
            'grade5_conduct' => 'nullable|string',
            'grade5_math_avg' => 'nullable|numeric|min:0|max:10',
            'grade5_literature_avg' => 'nullable|numeric|min:0|max:10',
            'is_disabled' => 'nullable|string|max:500',
            'achievements' => 'nullable|string|max:500',
            'achievement_rank' => 'nullable|string|max:100',
            'academic_transcript.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'additional_documents' => 'required|array|min:1',
            'additional_documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('\\n', $errors);
            return back()->withInput()->with('error_alert', $errorMessage);
        }
        
        try {
            $data = $request->except(['academic_transcript', 'additional_documents']);
            
            // Xử lý upload nhiều file học bạ
            if ($request->hasFile('academic_transcript')) {
                $academicPaths = [];
                foreach ($request->file('academic_transcript') as $file) {
                    $academicFileName = time() . '_' . uniqid() . '_hocba_' . $file->getClientOriginalName();
                    $academicPath = $file->storeAs('uploads/hoc-ba/lop6', $academicFileName, 'public');
                    $academicPaths[] = $academicPath;
                }
                $data['academic_transcript_path'] = json_encode($academicPaths);
            }
            
            // Xử lý upload các file bổ sung
            if ($request->hasFile('additional_documents')) {
                $additionalPaths = [];
                foreach ($request->file('additional_documents') as $file) {
                    $additionalFileName = time() . '_' . uniqid() . '_bosung_' . $file->getClientOriginalName();
                    $additionalPath = $file->storeAs('uploads/hoc-ba/lop6/bo-sung', $additionalFileName, 'public');
                    $additionalPaths[] = $additionalPath;
                }
                $data['additional_documents_paths'] = json_encode($additionalPaths);
            }
            
            $data['documents_uploaded_at'] = now();
            
            DangKyLop6::create($data);
            return back()->with('success_alert', 'Đăng ký thành công! Hồ sơ đã được tải lên. Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            \Log::error('Lỗi đăng ký lớp 6: ' . $e->getMessage());
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
            'ethnicity' => 'nullable|string|max:255',
            'birthplace' => 'nullable|string|max:255',
            'address' => 'required|string',
            'citizen_id' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'current_school' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_ethnicity' => 'nullable|string|max:100',
            'father_birthyear' => 'nullable|integer|min:1920|max:2010',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_ethnicity' => 'nullable|string|max:100',
            'mother_birthyear' => 'nullable|integer|min:1920|max:2010',
            'mother_occupation' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birthyear' => 'nullable|integer|min:1920|max:2010',
            'guardian_occupation' => 'nullable|string|max:255',
            'grade6_academic' => 'nullable|string',
            'grade6_conduct' => 'nullable|string',
            'grade7_academic' => 'nullable|string',
            'grade7_conduct' => 'nullable|string',
            'grade8_academic' => 'nullable|string',
            'grade8_conduct' => 'nullable|string',
            'grade9_academic' => 'nullable|string',
            'grade9_conduct' => 'nullable|string',
            'grade9_math_avg' => 'nullable|numeric|min:0|max:10',
            'grade9_literature_avg' => 'nullable|numeric|min:0|max:10',
            'is_disabled' => 'nullable|string|max:500',
            'achievements' => 'nullable|string|max:500',
            'achievement_rank' => 'nullable|string|max:100',
            'academic_transcript.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
            'additional_documents' => 'required|array|min:1',
            'additional_documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:20480'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('\\n', $errors);
            return back()->withInput()->with('error_alert', $errorMessage);
        }
        
        try {
            $data = $request->except(['academic_transcript', 'additional_documents']);
            
            // Xử lý upload nhiều file học bạ
            if ($request->hasFile('academic_transcript') && !empty($request->file('academic_transcript')[0])) {
                $academicPaths = [];
                foreach ($request->file('academic_transcript') as $file) {
                    if ($file) {
                        $academicFileName = time() . '_' . uniqid() . '_hocba_' . $file->getClientOriginalName();
                        $academicPath = $file->storeAs('uploads/hoc-ba/lop10', $academicFileName, 'public');
                        $academicPaths[] = $academicPath;
                    }
                }
                if (!empty($academicPaths)) {
                    $data['academic_transcript_path'] = json_encode($academicPaths);
                }
            }
            
            // Xử lý upload các file bổ sung
            if ($request->hasFile('additional_documents')) {
                $additionalPaths = [];
                foreach ($request->file('additional_documents') as $file) {
                    if ($file) {
                        $additionalFileName = time() . '_' . uniqid() . '_bosung_' . $file->getClientOriginalName();
                        $additionalPath = $file->storeAs('uploads/hoc-ba/lop10/bo-sung', $additionalFileName, 'public');
                        $additionalPaths[] = $additionalPath;
                    }
                }
                if (!empty($additionalPaths)) {
                    $data['additional_documents_paths'] = json_encode($additionalPaths);
                }
            }
            
            $data['documents_uploaded_at'] = now();
            
            DangKyLop10::create($data);
            return back()->with('success_alert', 'Đăng ký thành công! Học bạ đã được tải lên. Chúng tôi sẽ liên hệ với bạn sớm nhất.');
        } catch (\Exception $e) {
            \Log::error('Lỗi đăng ký lớp 10: ' . $e->getMessage());
            return back()->withInput()->with('error_alert', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại: ' . $e->getMessage());
        }
    }
}
