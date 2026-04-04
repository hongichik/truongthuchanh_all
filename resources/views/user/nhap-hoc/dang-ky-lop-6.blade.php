@extends('layouts.app')

@section('title', 'Đăng ký tuyển sinh vào lớp 6 - Trường TH, THCS và THPT Thực hành Sư phạm - Đại học Hạ Long')

@push('styles')
<style>
    .registration-form {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        margin: 20px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-section {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #e9ecef;
        border-radius: 5px;
        background: #f8f9fa;
    }
    
    .form-section h3 {
        color: #2c5530;
        font-size: 18px;
        margin-bottom: 20px;
        border-bottom: 2px solid #28a745;
        padding-bottom: 10px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.15s ease-in-out;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .form-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .form-col {
        flex: 1;
        min-width: 200px;
    }
    
    .form-col-2 {
        flex: 2;
        min-width: 300px;
    }
    
    .btn-submit {
        background: #28a745;
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin: 10px 5px;
    }
    
    .btn-submit:hover {
        background: #218838;
    }
    
    .btn-reset {
        background: #6c757d;
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin: 10px 5px;
    }
    
    .btn-reset:hover {
        background: #5a6268;
    }
    
    .required { color: red; }
    .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
    .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
    .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    label { display: block; margin-bottom: 5px; font-weight: 500; color: #495057; }
    .form-group { margin-bottom: 20px; }
    .text-danger { color: #dc3545; font-size: 12px; }
    
    @media (max-width: 768px) {
        .form-row { flex-direction: column; }
        .registration-form { padding: 20px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div style="text-align: center; margin: 30px 0;">
        <h1 style="color: #2c5530;">
            <i class="fas fa-user-graduate"></i>
            ĐĂNG KÝ TUYỂN SINH VÀO LỚP 6
        </h1>
        <p style="font-size: 16px; color: #666;">Vui lòng điền đầy đủ thông tin vào form dưới đây</p>
    </div>
    
    <div class="registration-form">
        <form method="POST" action="{{ route('dang-ky.lop6.store') }}">
            @csrf
          
            <!-- Thông tin cá nhân học sinh -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> I. THÔNG TIN CÁ NHÂN HỌC SINH</h3>
                
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="fullname">1. Họ và tên <span class="required">*</span></label>
                            <input type="text" id="fullname" name="fullname" class="form-control" 
                                   style="text-transform: uppercase;" placeholder="Nhập họ và tên đầy đủ" 
                                   value="{{ old('fullname') }}" required>
                            @error('fullname')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthdate">2. Ngày sinh <span class="required">*</span></label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" 
                                   value="{{ old('birthdate') }}" required>
                            @error('birthdate')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="gender">3. Giới tính <span class="required">*</span></label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="ethnicity">4. Dân tộc</label>
                            <input type="text" id="ethnicity" name="ethnicity" class="form-control" 
                                   placeholder="VD: Kinh, Tày, Nùng..." value="{{ old('ethnicity', 'Kinh') }}">
                            @error('ethnicity')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="current_school">5. Học sinh trường Tiểu học <span class="required">*</span></label>
                    <input type="text" id="current_school" name="current_school" class="form-control" 
                           placeholder="Nhập tên trường Tiểu học đang theo học" 
                           value="{{ old('current_school') }}" required>
                    @error('current_school')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="citizen_id">6. CCCD (số định danh)</label>
                    <input type="text" id="citizen_id" name="citizen_id" class="form-control" 
                           placeholder="Nhập số căn cước công dân (số định danh)" 
                           pattern="[0-9]{12}" value="{{ old('citizen_id') }}">
                    @error('citizen_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="address">7. Thông tin cư trú <span class="required">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="3" 
                              placeholder="Nhập địa chỉ cư trú đầy đủ" required>{{ old('address') }}</textarea>
                    @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
          
            <!-- Thông tin gia đình -->
            <div class="form-section">
                <h3><i class="fas fa-users"></i> II. THÔNG TIN GIA ĐÌNH</h3>
                
                <div class="form-group">
                    <label for="guardian_name">8. Tên Bố hoặc Mẹ hoặc người bảo trợ <span class="required">*</span></label>
                    <input type="text" id="guardian_name" name="guardian_name" class="form-control" 
                           placeholder="Nhập tên bố hoặc mẹ hoặc người bảo trợ" 
                           value="{{ old('guardian_name') }}" required>
                    @error('guardian_name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">9. Số điện thoại liên lạc <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           placeholder="Nhập số điện thoại liên lạc" 
                           pattern="[0-9]{10,11}" value="{{ old('phone') }}" required>
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
          
            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> GỬI ĐĂNG KÝ
                </button>
                <button type="reset" class="btn-reset">
                    <i class="fas fa-refresh"></i> NHẬP LẠI
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-submit');
    const resetBtn = document.querySelector('.btn-reset');
    
    // Xác nhận trước khi submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        confirmAction(
            'Xác nhận đăng ký',
            'Bạn có chắc chắn muốn gửi đăng ký vào lớp 6 này không?',
            'Gửi đăng ký',
            'Hủy bỏ'
        ).then((result) => {
            if (result.isConfirmed) {
                // Disable button và hiển thị loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
                
                // Hiển thị loading toast
                Toast.fire({
                    icon: 'info',
                    title: 'Đang xử lý đăng ký...'
                });
                
                form.submit();
            }
        });
    });
    
    // Xác nhận trước khi reset form
    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        confirmAction(
            'Xóa thông tin',
            'Bạn có chắc chắn muốn xóa tất cả thông tin đã nhập không?',
            'Xóa tất cả',
            'Hủy bỏ'
        ).then((result) => {
            if (result.isConfirmed) {
                form.reset();
                Toast.fire({
                    icon: 'success',
                    title: 'Đã xóa tất cả thông tin!'
                });
            }
        });
    });
    
    // Format phone number
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
    
    // Auto uppercase fullname
    const fullnameInput = document.getElementById('fullname');
    fullnameInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
    
    // Hiệu ứng focus vào các input
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush

@endsection