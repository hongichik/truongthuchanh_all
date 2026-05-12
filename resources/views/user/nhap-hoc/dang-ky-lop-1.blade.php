@extends('layouts.app')

@section('title', 'Trang đăng ký tuyển sinh vào lớp 1 Trường thực hành sư phạm Đại học Hạ Long')
@section('meta_description', 'Trang đăng ký tuyển sinh vào lớp 1 Trường thực hành sư phạm Đại học Hạ Long')

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
    
    .required {
        color: red;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #495057;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
        
        .registration-form {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div style="text-align: center; margin: 30px 0;">
        <h1 style="color: #2c5530;">
            <i class="fas fa-graduation-cap"></i>
            ĐĂNG KÝ TUYỂN SINH VÀO LỚP 1
        </h1>
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">
            Vui lòng điền đầy đủ thông tin vào form dưới đây
        </p>
    </div>
    
    <div class="registration-form">
        <form method="POST" action="{{ route('dang-ky.lop1.store') }}">
            @csrf
          
            <!-- Thông tin cá nhân học sinh -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> I. THÔNG TIN CÁ NHÂN HỌC SINH</h3>
                
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="fullname">1. Họ và tên <span class="required">*</span></label>
                            <input type="text" id="fullname" name="fullname" class="form-control" 
                                   style="text-transform: uppercase;" 
                                   placeholder="Nhập họ và tên đầy đủ" 
                                   value="{{ old('fullname', '') }}" required>
                            @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="birthdate">2. Ngày sinh <span class="required">*</span></label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" 
                                   value="{{ old('birthdate', '') }}" required>
                            @error('birthdate')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="gender">3. Giới tính <span class="required">*</span></label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Nam" {{ old('gender', '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gender', '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="ethnicity">4. Dân tộc</label>
                            <input type="text" id="ethnicity" name="ethnicity" class="form-control" 
                                   placeholder="VD: Kinh, Tày, Nùng..." 
                                   value="{{ old('ethnicity', '') }}">
                            @error('ethnicity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="citizen_id">5. CCCD (số định danh)</label>
                    <input type="text" id="citizen_id" name="citizen_id" class="form-control" 
                           placeholder="Nhập số căn cước công dân (số định danh)" 
                           pattern="[0-9]{12}" value="{{ old('citizen_id', '') }}">
                    @error('citizen_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="address">6. Thông tin cư trú <span class="required">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="3" 
                              placeholder="Nhập địa chỉ cư trú đầy đủ (số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố)" 
                              required>{{ old('address', '') }}</textarea>
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="birthplace">7. Nơi sinh (Tỉnh/Thành phố)</label>
                    <input type="text" id="birthplace" name="birthplace" class="form-control"
                           placeholder="VD: Phường Hạ Long - Tỉnh Quảng Ninh" value="{{ old('birthplace', '') }}">
                    @error('birthplace')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">8. Số điện thoại liên lạc <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           placeholder="Nhập số điện thoại liên lạc" 
                           pattern="[0-9]{10,11}" value="{{ old('phone', '') }}" required>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
          
            <!-- Thông tin gia đình -->
            <div class="form-section">
                <h3><i class="fas fa-users"></i> II. THÔNG TIN GIA ĐÌNH</h3>

                <h4 style="color: #495057; margin-top: 20px; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">A. THÔNG TIN CHA</h4>
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="father_name">9. Họ tên Cha</label>
                            <input type="text" id="father_name" name="father_name" class="form-control"
                                   placeholder="Nhập họ tên bố" value="{{ old('father_name', '') }}">
                            @error('father_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="father_ethnicity">Dân tộc</label>
                            <input type="text" id="father_ethnicity" name="father_ethnicity" class="form-control"
                                   placeholder="Kinh" value="{{ old('father_ethnicity', '') }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="father_birthyear">Năm sinh</label>
                            <input type="number" id="father_birthyear" name="father_birthyear" class="form-control"
                                   placeholder="VD: 1985" min="1920" max="2010" value="{{ old('father_birthyear', '') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="father_occupation">Nghề nghiệp</label>
                            <input type="text" id="father_occupation" name="father_occupation" class="form-control"
                                   placeholder="VD: Công nhân, Nông dân..." value="{{ old('father_occupation', '') }}">
                        </div>
                    </div>
                </div>

                <h4 style="color: #495057; margin-top: 20px; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">B. THÔNG TIN MẸ</h4>
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="mother_name">10. Họ tên Mẹ</label>
                            <input type="text" id="mother_name" name="mother_name" class="form-control"
                                   placeholder="Nhập họ tên mẹ" value="{{ old('mother_name', '') }}">
                            @error('mother_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_ethnicity">Dân tộc</label>
                            <input type="text" id="mother_ethnicity" name="mother_ethnicity" class="form-control"
                                   placeholder="Kinh" value="{{ old('mother_ethnicity', '') }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_birthyear">Năm sinh</label>
                            <input type="number" id="mother_birthyear" name="mother_birthyear" class="form-control"
                                   placeholder="VD: 1987" min="1920" max="2010" value="{{ old('mother_birthyear', '') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_occupation">Nghề nghiệp</label>
                            <input type="text" id="mother_occupation" name="mother_occupation" class="form-control"
                                   placeholder="VD: Giáo viên, Nội trợ..." value="{{ old('mother_occupation', '') }}">
                        </div>
                    </div>
                </div>

                <h4 style="color: #495057; margin-top: 20px; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">11. NGƯỜI GIÁM HỘ (NẾU CÓ)</h4>
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="guardian_name">Họ tên Người giám hộ</label>
                            <input type="text" id="guardian_name" name="guardian_name" class="form-control"
                                   placeholder="Nhập họ tên người giám hộ" value="{{ old('guardian_name', '') }}">
                            @error('guardian_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="guardian_birthyear">Năm sinh</label>
                            <input type="number" id="guardian_birthyear" name="guardian_birthyear" class="form-control"
                                   placeholder="VD: 1980" min="1920" max="2010" value="{{ old('guardian_birthyear', '') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="guardian_occupation">Nghề nghiệp</label>
                            <input type="text" id="guardian_occupation" name="guardian_occupation" class="form-control"
                                   placeholder="VD: Kinh doanh, Tự do..." value="{{ old('guardian_occupation', '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin đặc biệt -->
            <div class="form-section">
                <h3><i class="fas fa-star"></i> III. THÔNG TIN ĐẶC BIỆT</h3>

                <div class="form-group">
                    <label for="is_disabled">12. Trường hợp đặc biệt, học sinh là người khuyết tật</label>
                    <input type="text" id="is_disabled" name="is_disabled" class="form-control"
                           placeholder="Ghi rõ dạng tật (nếu có). Để trống nếu không" value="{{ old('is_disabled', '') }}">
                    <small class="text-muted">Ví dụ: Khiếm thị, Khiếc, Khuyết tật vận động...</small>
                    @error('is_disabled')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="achievements">13. Học sinh đạt giải cấp quốc tế, quốc gia, cấp tỉnh các cuộc thi</label>
                    <div class="form-row">
                        <div class="form-col-2">
                            <input type="text" id="achievements" name="achievements" class="form-control"
                                   placeholder="Ghi rõ tên Cuộc thi/Hội thi/Giải đấu (nếu có)"
                                   value="{{ old('achievements', '') }}" maxlength="500">
                        </div>
                        <div class="form-col">
                            <input type="text" id="achievement_rank" name="achievement_rank" class="form-control"
                                   placeholder="Giải cao nhất đạt được"
                                   value="{{ old('achievement_rank', '') }}" maxlength="100">
                        </div>
                    </div>
                    <small class="text-muted">Ví dụ: Cuộc thi Trạng Nguyên Toàn Tài cấp Tỉnh - Giải Nhất</small>
                </div>

                <div class="form-group">
                    <label>
                        Đơn đăng ký
                        <a href="{{ asset('assets/mau_don_lop_1.doc') }}" download>
                            Tải mẫu đơn lớp 1
                        </a>
                    </label>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Tải mẫu đơn để điền thông tin theo hướng dẫn tuyển sinh lớp 1.
                    </small>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// SweetAlert2 wrapper functions
function confirmAction(title, text, confirmText = 'Xác nhận', cancelText = 'Hủy') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true
    });
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function getFormPreviewItems(form) {
    const fields = form.querySelectorAll('input, select, textarea');
    const items = [];

    fields.forEach((field) => {
        if (!field.name || field.disabled || field.type === 'hidden') return;
        if ((field.type === 'checkbox' || field.type === 'radio') && !field.checked) return;

        const labelEl = field.id ? form.querySelector(`label[for="${field.id}"]`) : null;
        const label = (labelEl ? labelEl.textContent : field.name).replace(/\*/g, '').trim();

        let value = '';
        if (field.type === 'file') {
            if (!field.files || field.files.length === 0) return;
            value = Array.from(field.files).map((f) => f.name).join(', ');
        } else {
            value = (field.value || '').trim();
            if (!value) return;
        }

        items.push({ label, value });
    });

    return items;
}

function buildPreviewHtml(form) {
    const items = getFormPreviewItems(form);
    if (items.length === 0) {
        return '<p style="text-align:left; margin:0;">Chưa có dữ liệu để gửi.</p>';
    }

    const rows = items
        .map((item) => `<tr><td style="padding:8px;border:1px solid #dee2e6;font-weight:600;vertical-align:top;">${escapeHtml(item.label)}</td><td style="padding:8px;border:1px solid #dee2e6;">${escapeHtml(item.value)}</td></tr>`)
        .join('');

    return `<div style="max-height:420px;overflow:auto;text-align:left;"><table style="width:100%;border-collapse:collapse;font-size:14px;"><tbody>${rows}</tbody></table></div>`;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-submit');
    const resetBtn = document.querySelector('.btn-reset');

    @if (session('success_alert'))
    Swal.fire({
        icon: 'success',
        title: 'Đã gửi thành công',
        text: @json(session('success_alert')),
        confirmButtonColor: '#28a745'
    });
    @endif

    @if (session('error_alert'))
    Swal.fire({
        icon: 'error',
        title: 'Gửi chưa thành công',
        text: @json(session('error_alert')),
        confirmButtonColor: '#dc3545'
    });
    @endif
    
    // Xem lại thông tin trước khi submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Kiểm tra thông tin trước khi gửi',
            html: buildPreviewHtml(form),
            icon: 'info',
            width: 900,
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Thông tin đúng, gửi ngay',
            cancelButtonText: 'Sửa lại thông tin',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

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