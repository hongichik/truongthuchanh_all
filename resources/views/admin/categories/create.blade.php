@extends('layouts.layout-master')

@section('title', 'Thêm danh mục')
@section('page_title', 'Thêm danh mục')

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chính</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Nhập tên danh mục"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug (URL)</label>
                                <input type="text" 
                                       class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" 
                                       name="slug" 
                                       value="{{ old('slug') }}" 
                                       placeholder="Slug tự động tạo từ tên danh mục">
                                <small class="form-text text-muted">Để trống để tự động tạo từ tên danh mục</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Nhập mô tả cho danh mục">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cài đặt</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="color">Màu danh mục <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" 
                                           class="form-control @error('color') is-invalid @enderror" 
                                           id="color" 
                                           name="color" 
                                           value="{{ old('color', '#6c757d') }}" 
                                           style="height: 38px;"
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-palette"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sort_order">Thứ tự sắp xếp</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}" 
                                       min="0" 
                                       placeholder="0">
                                <small class="form-text text-muted">Số nhỏ sẽ hiển thị trước</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu danh mục
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy bỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const slug = name
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        
        $('#slug').val(slug);
    });

    // Form validation
    $('form').on('submit', function(e) {
        const name = $('#name').val().trim();
        if (!name) {
            e.preventDefault();
            toastr.error('Vui lòng nhập tên danh mục!');
            $('#name').focus();
        }
    });
});
</script>
@endpush