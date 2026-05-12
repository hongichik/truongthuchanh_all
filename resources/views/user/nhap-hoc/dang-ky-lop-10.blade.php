@extends('layouts.app')

@section('title', 'Trang đăng ký tuyển sinh vào lớp 10 Trường thực hành sư phạm Đại học Hạ Long')
@section('meta_description', 'Trang đăng ký tuyển sinh vào lớp 10 Trường thực hành sư phạm Đại học Hạ Long')

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
    
    .form-control[type="file"] {
        padding: 8px;
        background: #f8f9fa;
        border: 2px dashed #28a745;
    }
    
    .form-control[type="file"]:focus {
        border-color: #28a745;
        background: #e8f5e8;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    /* File preview styles */
    .file-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .file-preview-item {
        position: relative;
        width: 120px;
        height: 120px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .file-preview-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    
    .file-preview-item .file-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px;
        font-size: 10px;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .file-preview-item .remove-file {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .file-preview-item .file-icon {
        font-size: 40px;
        color: #6c757d;
    }
    
    .compressing {
        opacity: 0.6;
    }
    
    .compress-progress {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        background: rgba(40, 167, 69, 0.8);
        color: white;
        padding: 2px;
        font-size: 9px;
        text-align: center;
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
        <form method="POST" action="{{ route('dang-ky.lop10.store') }}" enctype="multipart/form-data">
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
                                   value="{{ old('birthdate', '') }}" required>
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
                                <option value="Nam" {{ old('gender', '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gender', '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="ethnicity">4. Dân tộc</label>
                            <input type="text" id="ethnicity" name="ethnicity" class="form-control" 
                                   placeholder="VD: Kinh, Tày, Nùng..." value="{{ old('ethnicity', '') }}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="current_school">5. Học sinh trường THCS <span class="required">*</span></label>
                    <input type="text" id="current_school" name="current_school" class="form-control" 
                           placeholder="Nhập tên trường THCS đang theo học" 
                           value="{{ old('current_school', '') }}" required>
                    @error('current_school')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="citizen_id">6. CCCD (số định danh)</label>
                    <input type="text" id="citizen_id" name="citizen_id" class="form-control" 
                           placeholder="Nhập số căn cước công dân (số định danh)" 
                           pattern="[0-9]{12}" value="{{ old('citizen_id', '') }}">
                </div>
                
                <div class="form-group">
                    <label for="address">7. Thông tin cư trú <span class="required">*</span></label>
                    <textarea id="address" name="address" class="form-control" rows="3" 
                              placeholder="Nhập địa chỉ cư trú đầy đủ" required>{{ old('address', '') }}</textarea>
                    @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="birthplace">8. Nơi sinh (Tỉnh/Thành phố)</label>
                    <input type="text" id="birthplace" name="birthplace" class="form-control" 
                              placeholder="VD: Phường Hạ Long - Tỉnh Quảng Ninh" value="{{ old('birthplace', '') }}">
                    @error('birthplace')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">9. Số điện thoại liên lạc <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           placeholder="Nhập số điện thoại liên lạc" 
                           pattern="[0-9]{10,11}" value="{{ old('phone', '') }}" required>
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
          
            <!-- Thông tin gia đình -->
            <div class="form-section">
                <h3><i class="fas fa-users"></i> II. THÔNG TIN GIA ĐÌNH</h3>
                
                <h4 style="color: #495057; margin-top: 20px; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">A. THÔNG TIN CHA</h4>
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="father_name">10. Họ tên Cha</label>
                            <input type="text" id="father_name" name="father_name" class="form-control" 
                                   placeholder="Nhập họ tên bố" value="{{ old('father_name', '') }}">
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
                                   placeholder="VD: 1965" min="1920" max="2010" value="{{ old('father_birthyear', '') }}">
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
                            <label for="mother_name">11. Họ tên Mẹ</label>
                            <input type="text" id="mother_name" name="mother_name" class="form-control" 
                                   placeholder="Nhập họ tên mẹ" value="{{ old('mother_name', '') }}">
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
                                   placeholder="VD: 1968" min="1920" max="2010" value="{{ old('mother_birthyear', '') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="mother_occupation">Nghề nghiệp</label>
                            <input type="text" id="mother_occupation" name="mother_occupation" class="form-control" 
                                   placeholder="VD: Giáo viên, Bác sĩ..." value="{{ old('mother_occupation', '') }}">
                        </div>
                    </div>
                </div>
                
                <h4 style="color: #495057; margin-top: 20px; margin-bottom: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">12.NGƯỜI GIÁM HỘ</h4>
                <div class="form-row">
                    <div class="form-col-2">
                        <div class="form-group">
                            <label for="guardian_name">12. Họ tên Người giám hộ</label>
                            <input type="text" id="guardian_name" name="guardian_name" class="form-control" 
                                   placeholder="Nhập họ tên người giám hộ (nếu có)" value="{{ old('guardian_name', '') }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="guardian_birthyear">Năm sinh</label>
                            <input type="number" id="guardian_birthyear" name="guardian_birthyear" class="form-control" 
                                   placeholder="VD: 1965" min="1920" max="2010" value="{{ old('guardian_birthyear', '') }}">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="guardian_occupation">Nghề nghiệp</label>
                            <input type="text" id="guardian_occupation" name="guardian_occupation" class="form-control" 
                                   placeholder="VD: Doanh nhân, Tự do..." value="{{ old('guardian_occupation', '') }}">
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
                                <option value="Tốt" {{ old('grade6_academic', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade6_academic', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade6_academic', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade6_academic', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade6_conduct">Hạnh kiểm</label>
                            <select id="grade6_conduct" name="grade6_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade6_conduct', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade6_conduct', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade6_conduct', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade6_conduct', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
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
                                <option value="Tốt" {{ old('grade7_academic', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade7_academic', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade7_academic', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade7_academic', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade7_conduct">Hạnh kiểm</label>
                            <select id="grade7_conduct" name="grade7_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade7_conduct', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade7_conduct', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade7_conduct', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade7_conduct', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
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
                                <option value="Tốt" {{ old('grade8_academic', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade8_academic', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade8_academic', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade8_academic', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade8_conduct">Hạnh kiểm</label>
                            <select id="grade8_conduct" name="grade8_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade8_conduct', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade8_conduct', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade8_conduct', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade8_conduct', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="academic-year">
                    <h4>Lớp 9</h4>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="grade9_academic">Kết quả học lực lớp 9</label>
                            <select id="grade9_academic" name="grade9_academic" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade9_academic', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade9_academic', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade9_academic', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade9_academic', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="grade9_conduct">Hạnh kiểm lớp 9</label>
                            <select id="grade9_conduct" name="grade9_conduct" class="form-control">
                                <option value="">-- Chọn xếp loại --</option>
                                <option value="Tốt" {{ old('grade9_conduct', '') == 'Tốt' ? 'selected' : '' }}>Tốt</option>
                                <option value="Khá" {{ old('grade9_conduct', '') == 'Khá' ? 'selected' : '' }}>Khá</option>
                                <option value="Đạt" {{ old('grade9_conduct', '') == 'Đạt' ? 'selected' : '' }}>Đạt</option>
                                <option value="Chưa đạt" {{ old('grade9_conduct', '') == 'Chưa đạt' ? 'selected' : '' }}>Chưa đạt</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Điểm trung bình các môn lớp 9 -->
                    <div class="form-row" style="margin-top: 15px;">
                        <div class="form-col">
                            <label for="grade9_math_avg">Điểm trung bình Toán lớp 9</label>
                            <input type="number" id="grade9_math_avg" name="grade9_math_avg" class="form-control" 
                                   min="0" max="10" step="0.1" placeholder="Ví dụ: 8.5" value="{{ old('grade9_math_avg', '') }}">
                            <small class="text-muted">Nhập điểm từ 0.0 đến 10.0</small>
                            @error('grade9_math_avg')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-col">
                            <label for="grade9_literature_avg">Điểm trung bình Văn lớp 9</label>
                            <input type="number" id="grade9_literature_avg" name="grade9_literature_avg" class="form-control" 
                                   min="0" max="10" step="0.1" placeholder="Ví dụ: 8.0" value="{{ old('grade9_literature_avg', '') }}">
                            <small class="text-muted">Nhập điểm từ 0.0 đến 10.0</small>
                            @error('grade9_literature_avg')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Upload học bạ -->
            <div class="form-section">
                <h3><i class="fas fa-file-upload"></i> IV. TẢI LÊN HỌC BẠ</h3>
                
                <div class="form-group">
                    <label for="academic_transcript">Học bạ THCS (nhiều ảnh PDF, JPG, PNG)<span class="required">*</span></label>
                    <input type="file" id="academic_transcript" name="academic_transcript[]" class="form-control" 
                           accept=".pdf,.jpg,.jpeg,.png" multiple required>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Chọn nhiều ảnh cùng lúc: học bạ từ lớp 6-9, bằng tốt nghiệp THCS... 
                        Ảnh sẽ được tự động nén để tối ưu tốc độ tải.
                    </small>
                    <div id="academic_preview" class="mt-2"></div>
                    @error('academic_transcript')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="additional_documents">
                        Đơn đăng ký <span class="required">*</span>
                        <a href="{{ asset('assets/' . rawurlencode('MẪU PHIẾU ĐĂNG KÍ XÉT TUYỂN VÀO   LỚP 10 - NĂM HỌC  2026 - 2027.doc')) }}" download>
                            Tải mẫu đơn lớp 10
                        </a>
                    </label>
                    <input type="file" id="additional_documents" name="additional_documents[]" class="form-control" 
                           accept=".pdf,.jpg,.jpeg,.png" multiple required>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Upload đơn đăng ký đã điền (PDF/JPG/PNG), có thể kèm giấy tờ bổ sung nếu cần.
                    </small>
                    <div id="additional_preview" class="mt-2"></div>
                    @error('additional_documents')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <!-- Thông tin đặc biệt -->
            <div class="form-section">
                <h3><i class="fas fa-star"></i> V. THÔNG TIN ĐẶC BIỆT</h3>
                
                <div class="form-group">
                    <label for="is_disabled">13. Trường hợp đặc biệt, học sinh là người khuyết tật</label>
                    <input type="text" id="is_disabled" name="is_disabled" class="form-control" 
                           placeholder="Ghi rõ dạng tật (nếu có). Để trống nếu không" value="{{ old('is_disabled', '') }}">
                    <small class="text-muted">Ví dụ: Khiếm thị, Khiếc, Khuyết tật vận động...</small>
                    @error('is_disabled')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                <div class="form-group">
                    <label for="achievements">14. Học sinh đạt giải cấp quốc tế, quốc gia, cấp tỉnh các cuộc thi</label>
                    <div class="form-row">
                        <div class="form-col-2">
                            <input type="text" id="achievements" name="achievements" class="form-control" 
                                   placeholder="Ghi rõ tên Cuộc thi/Hội thi/Giải đấu (nếu có)" 
                                   value="{{ old('achievements', 'Cuộc thi Học sinh giỏi Toán cấp Tỉnh') }}" maxlength="500">
                            @error('achievements')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-col">
                            <input type="text" id="achievement_rank" name="achievement_rank" class="form-control" 
                                   placeholder="Giải cao nhất đạt được" 
                                   value="{{ old('achievement_rank', 'Giải Ba') }}" maxlength="100">
                            @error('achievement_rank')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <small class="text-muted">Ví dụ: Cuộc thi Học sinh giỏi Toán cấp Quốc gia - Giải Nhất</small>
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
<!-- SweetAlert2 for beautiful alerts -->
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
        const gradeFieldMatch = field.name.match(/^grade(\d+)_(academic|conduct)$/);
        const label = gradeFieldMatch
            ? (gradeFieldMatch[2] === 'academic'
                ? `Kết quả học lực lớp ${gradeFieldMatch[1]}`
                : `Hạnh kiểm lớp ${gradeFieldMatch[1]}`)
            : (labelEl ? labelEl.textContent : field.name).replace(/\*/g, '').trim();

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

// Image compression and preview functionality
class ImageCompressor {
    constructor(maxWidth = 1200, maxHeight = 1600, quality = 0.8) {
        this.maxWidth = maxWidth;
        this.maxHeight = maxHeight;
        this.quality = quality;
        this.maxFileSize = 1024 * 1024; // 1MB after compression
    }

    compressImage(file) {
        return new Promise((resolve) => {
            if (file.type === 'application/pdf') {
                resolve(file); // Don't compress PDF files
                return;
            }

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.onload = () => {
                // Calculate new dimensions
                let { width, height } = this.calculateDimensions(img.width, img.height);
                
                canvas.width = width;
                canvas.height = height;

                // Draw and compress
                ctx.drawImage(img, 0, 0, width, height);
                
                canvas.toBlob((blob) => {
                    if (!blob) { resolve(file); return; }
                    // If still too large, compress more
                    if (blob.size > this.maxFileSize && this.quality > 0.3) {
                        this.quality -= 0.1;
                        canvas.toBlob((blob2) => {
                            if (!blob2) { resolve(file); return; }
                            const compressedFile = new File([blob2], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        }, 'image/jpeg', this.quality);
                    } else {
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }
                }, 'image/jpeg', this.quality);
            };

            img.src = URL.createObjectURL(file);
        });
    }

    calculateDimensions(width, height) {
        if (width <= this.maxWidth && height <= this.maxHeight) {
            return { width, height };
        }

        const ratio = Math.min(this.maxWidth / width, this.maxHeight / height);
        return {
            width: Math.round(width * ratio),
            height: Math.round(height * ratio)
        };
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

// File manager for handling multiple uploads
class FileManager {
    constructor(inputElement, previewElement) {
        this.input = inputElement;
        this.preview = previewElement;
        this.files = [];
        this.compressor = new ImageCompressor();
        
        this.init();
    }

    init() {
        this.input.addEventListener('change', (e) => this.handleFileSelect(e));
        this.preview.innerHTML = '';
    }

    async handleFileSelect(event) {
        const selectedFiles = Array.from(event.target.files);
        
        for (let file of selectedFiles) {
            await this.addFile(file);
        }
        
        this.updateInputFiles();
    }

    async addFile(file) {
        const previewItem = this.createPreviewItem(file);
        this.preview.appendChild(previewItem);

        if (file.type.startsWith('image/')) {
            previewItem.classList.add('compressing');
            const progressDiv = previewItem.querySelector('.compress-progress');
            if (progressDiv) progressDiv.textContent = 'Đang nén ảnh...';

            try {
                const compressedFile = await this.compressor.compressImage(file);
                const index = this.files.push(compressedFile) - 1;
                
                previewItem.classList.remove('compressing');
                if (progressDiv) progressDiv.remove();
                
                // Update file info
                const fileInfo = previewItem.querySelector('.file-info');
                if (fileInfo) {
                    const originalSize = this.compressor.formatFileSize(file.size);
                    const compressedSize = this.compressor.formatFileSize(compressedFile.size);
                    fileInfo.innerHTML = `${file.name}<br><small>${originalSize} → ${compressedSize}</small>`;
                }
                
                previewItem.dataset.fileIndex = index;
            } catch (error) {
                console.error('Compression failed:', error);
                const index = this.files.push(file) - 1;
                previewItem.dataset.fileIndex = index;
                previewItem.classList.remove('compressing');
            }
        } else {
            const index = this.files.push(file) - 1;
            previewItem.dataset.fileIndex = index;
        }
    }

    createPreviewItem(file) {
        const item = document.createElement('div');
        item.className = 'file-preview-item';
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-file';
        removeBtn.innerHTML = '×';
        removeBtn.onclick = (e) => {
            e.preventDefault();
            this.removeFile(item);
        };

        const progressDiv = document.createElement('div');
        progressDiv.className = 'compress-progress';
        progressDiv.textContent = 'Đang xử lý...';

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            item.appendChild(img);
        } else {
            const icon = document.createElement('i');
            icon.className = 'fas fa-file-pdf file-icon';
            item.appendChild(icon);
        }

        const fileInfo = document.createElement('div');
        fileInfo.className = 'file-info';
        fileInfo.innerHTML = `${file.name}<br><small>${this.compressor.formatFileSize(file.size)}</small>`;

        item.appendChild(removeBtn);
        item.appendChild(fileInfo);
        if (file.type.startsWith('image/')) {
            item.appendChild(progressDiv);
        }

        return item;
    }

    removeFile(previewItem) {
        const index = parseInt(previewItem.dataset.fileIndex);
        if (!isNaN(index)) {
            this.files.splice(index, 1);
            this.updateFileIndices();
        }
        previewItem.remove();
        this.updateInputFiles();
    }

    updateFileIndices() {
        const items = this.preview.querySelectorAll('.file-preview-item');
        items.forEach((item, index) => {
            item.dataset.fileIndex = index;
        });
    }

    updateInputFiles() {
        const dt = new DataTransfer();
        this.files.forEach(file => dt.items.add(file));
        this.input.files = dt.files;
    }
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
    
    // Initialize file managers
    const academicInput = document.getElementById('academic_transcript');
    const academicPreview = document.getElementById('academic_preview');
    const academicManager = new FileManager(academicInput, academicPreview);

    const additionalInput = document.getElementById('additional_documents');
    const additionalPreview = document.getElementById('additional_preview');  
    const additionalManager = new FileManager(additionalInput, additionalPreview);

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
                // Clear file previews
                academicPreview.innerHTML = '';
                additionalPreview.innerHTML = '';
                academicManager.files = [];
                additionalManager.files = [];
                
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