@extends('layouts.layout-master')

@section('title', 'Chi tiết Menu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Chi tiết Menu: {{ $menu->name }}</h3>
                    <div>
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">ID:</th>
                                    <td>{{ $menu->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên Menu:</th>
                                    <td>
                                        @if($menu->icon)
                                            <i class="{{ $menu->icon }}"></i>
                                        @endif
                                        {{ $menu->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code>{{ $menu->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>URL:</th>
                                    <td>
                                        @if($menu->url)
                                            <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="text-primary">
                                                {{ $menu->url }}
                                                @if($menu->target === '_blank')
                                                    <i class="fas fa-external-link-alt fa-xs"></i>
                                                @endif
                                            </a>
                                        @else
                                            <span class="text-muted">Không có URL</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Icon:</th>
                                    <td>
                                        @if($menu->icon)
                                            <i class="{{ $menu->icon }}"></i> 
                                            <code>{{ $menu->icon }}</code>
                                        @else
                                            <span class="text-muted">Không có icon</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mô tả:</th>
                                    <td>
                                        @if($menu->description)
                                            {{ $menu->description }}
                                        @else
                                            <span class="text-muted">Không có mô tả</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Menu cha:</th>
                                    <td>
                                        @if($menu->parent)
                                            <a href="{{ route('admin.menus.show', $menu->parent) }}" class="text-primary">
                                                {{ $menu->parent->name }}
                                            </a>
                                        @else
                                            <span class="badge badge-primary">Menu gốc</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo:</th>
                                    <td>{{ $menu->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối:</th>
                                    <td>{{ $menu->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Thông tin hiển thị</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Vị trí:</strong><br>
                                        <span class="badge badge-{{ $menu->position === 'header' ? 'primary' : ($menu->position === 'footer' ? 'secondary' : 'info') }} badge-lg">
                                            {{ ucfirst($menu->position) }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Thứ tự:</strong><br>
                                        <span class="badge badge-light badge-lg">{{ $menu->sort_order }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Loại liên kết:</strong><br>
                                        <span class="badge badge-info badge-lg">
                                            {{ $menu->target === '_self' ? 'Cùng tab' : 'Tab mới' }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Trạng thái:</strong><br>
                                        @if($menu->status === 'active')
                                            <span class="badge badge-success badge-lg">
                                                <i class="fas fa-check-circle"></i> Hoạt động
                                            </span>
                                        @else
                                            <span class="badge badge-danger badge-lg">
                                                <i class="fas fa-times-circle"></i> Vô hiệu hóa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($menu->hasChildren())
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Menu con ({{ $menu->children->count() }})</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Tên</th>
                                                        <th>Slug</th>
                                                        <th>URL</th>
                                                        <th>Thứ tự</th>
                                                        <th>Trạng thái</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($menu->children as $child)
                                                        <tr>
                                                            <td>
                                                                @if($child->icon)
                                                                    <i class="{{ $child->icon }}"></i>
                                                                @endif
                                                                {{ $child->name }}
                                                            </td>
                                                            <td><code>{{ $child->slug }}</code></td>
                                                            <td>
                                                                @if($child->url)
                                                                    <a href="{{ $child->url }}" target="{{ $child->target }}" class="text-primary">
                                                                        {{ Str::limit($child->url, 30) }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $child->sort_order }}</td>
                                                            <td>
                                                                @if($child->status === 'active')
                                                                    <span class="badge badge-success">Hoạt động</span>
                                                                @else
                                                                    <span class="badge badge-danger">Vô hiệu</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('admin.menus.show', $child) }}" 
                                                                       class="btn btn-info">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.menus.edit', $child) }}" 
                                                                       class="btn btn-warning">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($menu->parent)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-level-up-alt"></i> Đường dẫn menu:</h6>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                                            @foreach($menu->getFullPath() as $pathMenu)
                                                @if($loop->last)
                                                    <li class="breadcrumb-item active" aria-current="page">
                                                        {{ $pathMenu->name }}
                                                    </li>
                                                @else
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ route('admin.menus.show', $pathMenu) }}">
                                                            {{ $pathMenu->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.menus.create') }}?parent_id={{ $menu->id }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Thêm menu con
                    </a>
                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" style="display: inline-block;" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-menu">
                            <i class="fas fa-trash"></i> Xóa menu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Badge styles */
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    
    .badge-primary {
        color: #fff;
        background-color: #007bff;
    }
    
    .badge-secondary {
        color: #fff;
        background-color: #6c757d;
    }
    
    .badge-success {
        color: #fff;
        background-color: #28a745;
    }
    
    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }
    
    .badge-warning {
        color: #212529;
        background-color: #ffc107;
    }
    
    .badge-info {
        color: #fff;
        background-color: #17a2b8;
    }
    
    .badge-light {
        color: #212529;
        background-color: #f8f9fa;
    }
    
    .badge-dark {
        color: #fff;
        background-color: #343a40;
    }
    
    .badge-lg {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Xử lý xóa menu
    $(document).on('click', '.delete-menu', function(e) {
        e.preventDefault();
        
        @if($menu->hasChildren())
            alert('Không thể xóa menu có menu con. Vui lòng xóa menu con trước.');
        @else
            if (confirm('Bạn có chắc chắn muốn xóa menu này?')) {
                $(this).closest('form').submit();
            }
        @endif
    });
});
</script>
@endpush