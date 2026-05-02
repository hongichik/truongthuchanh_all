@extends('layouts.layout-master')

@section('title', 'Quản lý danh mục')
@section('page_title', 'Quản lý danh mục')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách danh mục</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Thêm danh mục
                    </a>
                </div>
            </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="categoriesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Tên</th>
                                        <th width="15%">Slug</th>
                                        <th width="25%">Mô tả</th>
                                        <th width="8%">Màu</th>
                                        <th width="8%">Thứ tự</th>
                                        <th width="8%">Bài viết</th>
                                        <th width="8%">Trạng thái</th>
                                        <th width="8%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($category->description, 50) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-preview" style="width:20px;height:20px;background:{{ $category->color }};border-radius:3px;border:1px solid #ddd;margin-right:8px;"></div>
                                                <small>{{ $category->color }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $category->sort_order }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $category->articles_count }}</span>
                                        </td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm toggle-status {{ $category->status === 'active' ? 'btn-success' : 'btn-secondary' }}"
                                                    data-id="{{ $category->id }}"
                                                    data-status="{{ $category->status }}">
                                                {{ $category->status === 'active' ? 'Hoạt động' : 'Tạm dừng' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.categories.show', $category->id) }}" 
                                                   class="btn btn-info btn-sm" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                                   class="btn btn-primary btn-sm" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-category" 
                                                        data-id="{{ $category->id }}"
                                                        data-name="{{ $category->name }}"
                                                        title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Form -->
        <form id="delete-form" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').click(function() {
        const categoryId = $(this).data('id');
        const currentStatus = $(this).data('status');
        const button = $(this);
        
        $.ajax({
            url: `/admin/categories/${categoryId}/toggle-status`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update button
                    if (response.status === 'active') {
                        button.removeClass('btn-secondary').addClass('btn-success');
                        button.text('Hoạt động');
                    } else {
                        button.removeClass('btn-success').addClass('btn-secondary');
                        button.text('Tạm dừng');
                    }
                    button.data('status', response.status);
                    
                    // Show toast
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra khi cập nhật trạng thái!');
            }
        });
    });

    // Delete category
    $('.delete-category').click(function() {
        const categoryId = $(this).data('id');
        const categoryName = $(this).data('name');
        
        Swal.fire({
            title: 'Xác nhận xóa',
            text: `Bạn có chắc chắn muốn xóa danh mục "${categoryName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form').attr('action', `/admin/categories/${categoryId}`);
                $('#delete-form').submit();
            }
        });
    });
});
</script>
@endpush