@extends('layouts.app')

@section('title', 'Đăng ký tuyển sinh vào lớp 10 - Trường TH, THCS và THPT Thực hành Sư phạm - Đại học Hạ Long')

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
    
    .academic-year {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        background: white;
    }
    
    .academic-year h4 {
        color: #495057;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .btn-submit, .btn-reset {
        padding: 15px 40px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin: 10px 5px;
    }
    
    .btn-submit {
        background: #28a745;
        color: white;
    }
    
    .btn-submit:hover { background: #218838; }
    
    .btn-reset {
        background: #6c757d;
        color: white;
    }
    
    .btn-reset:hover { background: #5a6268; }
    
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
            <i class="fas fa-child"></i>
            ĐĂNG KÝ TUYỂN SINH VÀO LỚP 10
        </h1>
        <p style="font-size: 16px; color: #666;">Vui lòng điền đầy đủ thông tin vào form dưới đây</p>
    </div>
    
    <div class="registration-form">
        <form method="POST" action="{{ route('dang-ky.lop10.store') }}">
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
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="current_school">5. Học sinh trường THCS <span class="required">*</span></label>
                    <input type="text" id="current_school" name="current_school" class="form-control" 
                           placeholder="Nhập tên trường THCS đang theo học" 
                           value="{{ old('current_school') }}" required>
                    @error('current_school')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="citizen_id">6. CCCD (số định danh)</label>
                    <input type="text" id="citizen_id" name="citizen_id" class="form-control" 
                           placeholder="Nhập số căn cước công dân (số định danh)" 
                           pattern="[0-9]{12}" value="{{ old('citizen_id') }}">
                </div>
                
                <div class="form-group">
                    <label for="address">7. Thông tin cư trú <span class="required">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="3" 
                              placeholder="Nhập địa chỉ cư trú đầy đủ" required>{{ old('address') }}</textarea>
                    @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">8. Số điện thoại liên lạc <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           placeholder="Nhập số điện thoại liên lạc" 
                           pattern="[0-9]{10,11}" value="{{ old('phone') }}" required>
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
          
            <!-- Thông tin gia đình -->
            <div class="form-section">
                <h3><i class="fas fa-users"></i> II. THÔNG TIN GIA ĐÌNH</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="father_name">9. Họ tên Cha</label>
                            <input type="text" id="father_name" name="father_name" class="form-control" 
                                   placeholder="Nhập họ tên bố" value="{{ old('father_name') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="father_ethnicity">10. Dân tộc Cha</label>
                            <input type="text" id="father_ethnicity" name="father_ethnicity" class="form-control" 
                                   placeholder="Dân tộc của bố" value="{{ old('father_ethnicity', 'Kinh') }}">
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_name">11. Họ tên Mẹ</label>
                            <input type="text" id="mother_name" name="mother_name" class="form-control" 
                                   placeholder="Nhập họ tên mẹ" value="{{ old('mother_name') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_ethnicity">12. Dân tộc Mẹ</label>
                            <input type="text" id="mother_ethnicity" name="mother_ethnicity" class="form-control" 
                                   placeholder="Dân tộc của mẹ" value="{{ old('mother_ethnicity', 'Kinh') }}">
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Kết quả học tập -->
            <div class="form-section">
                <h3><i class="fas fa-graduation-cap"></i> III. KẾT QUẢ HỌC TẬP CÁC NĂM</h3>
                
                <div class="academic-year">
                    <h4>Lớp 6</h4>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="grade6_academic">Kết quả học lực</label>
                            <select id="grade6_academic" name="grade6_academic" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Xuất sắc" {{ old('grade6_academic') == 'Xuất sắc' ? 'selected' : '' }}>Xuất sắc</option>
                                <option value="Giỏi" {{ old('grade6_academic') == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                                <option value="Khá" {{ old('grade6_academic') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade6_academic') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade6_academic') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade6_conduct">Hạnh kiểm</label>
                            <select id="grade6_conduct" name="grade6_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade6_conduct') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade6_conduct') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade6_conduct') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade6_conduct') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="academic-year">
                    <h4>Lớp 7</h4>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="grade7_academic">Kết quả học lực</label>
                            <select id="grade7_academic" name="grade7_academic" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Xuất sắc" {{ old('grade7_academic') == 'Xuất sắc' ? 'selected' : '' }}>Xuất sắc</option>
                                <option value="Giỏi" {{ old('grade7_academic') == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                                <option value="Khá" {{ old('grade7_academic') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade7_academic') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade7_academic') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade7_conduct">Hạnh kiểm</label>
                            <select id="grade7_conduct" name="grade7_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade7_conduct') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade7_conduct') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade7_conduct') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade7_conduct') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="academic-year">
                    <h4>Lớp 8</h4>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="grade8_academic">Kết quả học lực</label>
                            <select id="grade8_academic" name="grade8_academic" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Xuất sắc" {{ old('grade8_academic') == 'Xuất sắc' ? 'selected' : '' }}>Xuất sắc</option>
                                <option value="Giỏi" {{ old('grade8_academic') == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                                <option value="Khá" {{ old('grade8_academic') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade8_academic') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade8_academic') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade8_conduct">Hạnh kiểm</label>
                            <select id="grade8_conduct" name="grade8_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade8_conduct') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade8_conduct') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade8_conduct') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade8_conduct') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="academic-year">
                    <h4>Lớp 9</h4>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="grade9_academic">Kết quả học lực</label>
                            <select id="grade9_academic" name="grade9_academic" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Xuất sắc" {{ old('grade9_academic') == 'Xuất sắc' ? 'selected' : '' }}>Xuất sắc</option>
                                <option value="Giỏi" {{ old('grade9_academic') == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                                <option value="Khá" {{ old('grade9_academic') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade9_academic') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade9_academic') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade9_conduct">Hạnh kiểm</label>
                            <select id="grade9_conduct" name="grade9_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade9_conduct') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade9_conduct') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Trung bình" {{ old('grade9_conduct') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                                <option value="Yếu" {{ old('grade9_conduct') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Điểm trung bình các môn lớp 9 -->
                    <div class="form-row" style="margin-top: 15px;">
                        <div class="form-col">
                            <label for="grade9_math_avg">Điểm trung bình Toán lớp 9</label>
                            <input type="number" id="grade9_math_avg" name="grade9_math_avg" class="form-control" 
                                   min="0" max="10" step="0.1" placeholder="Ví dụ: 8.5" value="{{ old('grade9_math_avg') }}">
                            <small class="text-muted">Nhập điểm từ 0.0 đến 10.0</small>
                            @error('grade9_math_avg')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-col">
                            <label for="grade9_literature_avg">Điểm trung bình Văn lớp 9</label>
                            <input type="number" id="grade9_literature_avg" name="grade9_literature_avg" class="form-control" 
                                   min="0" max="10" step="0.1" placeholder="Ví dụ: 8.0" value="{{ old('grade9_literature_avg') }}">
                            <small class="text-muted">Nhập điểm từ 0.0 đến 10.0</small>
                            @error('grade9_literature_avg')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Thông tin đặc biệt -->
            <div class="form-section">
                <h3><i class="fas fa-star"></i> IV. THÔNG TIN ĐẶC BIỆT</h3>
                
                <div class="form-group">
                    <label for="is_disabled">13. Trường hợp đặc biệt, học sinh là người khuyết tật</label>
                    <select id="is_disabled" name="is_disabled" class="form-control">
                        <option value="">-- Chọn --</option>
                        <option value="Không" {{ old('is_disabled', 'Không') == 'Không' ? 'selected' : '' }}>Không</option>
                        <option value="Có" {{ old('is_disabled') == 'Có' ? 'selected' : '' }}>Có</option>
                    </select>
                    @error('is_disabled')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="achievements">14. Học sinh đạt giải cấp quốc tế, quốc gia, cấp tỉnh các cuộc thi</label>
                    <div class="form-row">
                        <div class="form-col-2">
                            <input type="text" id="achievements" name="achievements" class="form-control" 
                                   placeholder="Ghi rõ tên Cuộc thi/Hội thi/Giải đấu (nếu có)" 
                                   value="{{ old('achievements') }}" maxlength="500">
                            @error('achievements')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-col">
                            <input type="text" id="achievement_rank" name="achievement_rank" class="form-control" 
                                   placeholder="Giải cao nhất đạt được" 
                                   value="{{ old('achievement_rank') }}" maxlength="100">
                            @error('achievement_rank')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <small class="text-muted">Ví dụ: Cuộc thi Học sinh giỏi Toán cấp Quốc gia - Giải Nhất</small>
                </div>
                
                <div class="form-group">
                    <label for="is_policy_family">15. Học sinh là con gia đình chính sách</label>
                    <select id="is_policy_family" name="is_policy_family" class="form-control">
                        <option value="">-- Chọn --</option>
                        <option value="Không" {{ old('is_policy_family', 'Không') == 'Không' ? 'selected' : '' }}>Không</option>
                        <option value="Có" {{ old('is_policy_family') == 'Có' ? 'selected' : '' }}>Có</option>
                    </select>
                    @error('is_policy_family')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="special_info">16. Thông tin đặc biệt khác</label>
                    <textarea id="special_info" name="special_info" class="form-control" rows="4" 
                              placeholder="Ghi rõ các thông tin đặc biệt khác về học sinh (nếu có)" 
                              maxlength="1000">{{ old('special_info') }}</textarea>
                    <small class="text-muted">Tối đa 1000 ký tự</small>
                    @error('special_info')<small class="text-danger">{{ $message }}</small>@enderror
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
            'Bạn có chắc chắn muốn gửi đăng ký vào lớp 10 này không?',
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