@extends('layouts.layout-master')

@section('title', 'Thêm Menu Mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Thêm Menu Mới</h3>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <form action="{{ route('admin.menus.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Tên Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug') }}">
                                    <small class="form-text text-muted">Để trống để tự động tạo từ tên menu</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                           id="url" name="url" value="{{ old('url') }}" 
                                           placeholder="/trang-chu hoặc https://example.com">
                                    <small class="form-text text-muted">
                                        Có thể sử dụng URL tương đối (/trang-chu) hoặc URL đầy đủ (https://example.com)
                                    </small>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="icon">Icon (Font Awesome)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i id="icon-preview" class="{{ old('icon', 'fas fa-link') }}"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                               id="icon" name="icon" value="{{ old('icon') }}" 
                                               placeholder="fas fa-home">
                                    </div>
                                    <small class="form-text text-muted">
                                        Ví dụ: fas fa-home, fas fa-user, fas fa-cog
                                        <a href="https://fontawesome.com/icons" target="_blank">Xem thêm icon</a>
                                    </small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parent_id">Menu Cha</label>
                                    <select class="form-control @error('parent_id') is-invalid @enderror" 
                                            id="parent_id" name="parent_id">
                                        <option value="">-- Menu gốc --</option>
                                        @foreach($parentMenus as $parentMenu)
                                            <option value="{{ $parentMenu->id }}" 
                                                    {{ old('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                                                {{ $parentMenu->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sort_order">Thứ tự sắp xếp</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="target">Loại liên kết <span class="text-danger">*</span></label>
                                    <select class="form-control @error('target') is-invalid @enderror" 
                                            id="target" name="target" required>
                                        <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>
                                            Cùng tab (_self)
                                        </option>
                                        <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>
                                            Tab mới (_blank)
                                        </option>
                                    </select>
                                    @error('target')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                            Vô hiệu hóa
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="position">Vị trí hiển thị <span class="text-danger">*</span></label>
                                    <select class="form-control @error('position') is-invalid @enderror" 
                                            id="position" name="position" required>
                                        <option value="header" {{ old('position') === 'header' ? 'selected' : '' }}>
                                            Header
                                        </option>
                                        <option value="footer" {{ old('position') === 'footer' ? 'selected' : '' }}>
                                            Footer
                                        </option>
                                        <option value="sidebar" {{ old('position') === 'sidebar' ? 'selected' : '' }}>
                                            Sidebar
                                        </option>
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Menu
                        </button>
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tự động tạo slug từ tên menu
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
            .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
            .replace(/[ìíịỉĩ]/g, 'i')
            .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
            .replace(/[ùúụủũưừứựửữ]/g, 'u')
            .replace(/[ỳýỵỷỹ]/g, 'y')
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
            
        if ($('#slug').val() === '') {
            $('#slug').val(slug);
        }
    });

    // Preview icon
    $('#icon').on('input', function() {
        let iconClass = $(this).val() || 'fas fa-link';
        $('#icon-preview').attr('class', iconClass);
    });
});
</script>
@endpush