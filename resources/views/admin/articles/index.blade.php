@extends('layouts.layout-master')

@section('title', 'Quản lý bài viết')
@section('page_title', 'Quản lý bài viết')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách bài viết</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Thêm bài viết
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="status-filter" class="form-label">Trạng thái</label>
                        <select class="form-control" id="status-filter">
                            <option value="">Tất cả</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category-filter" class="form-label">Danh mục</label>
                        <select class="form-control" id="category-filter">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search-input" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="search-input" 
                               placeholder="Tìm kiếm theo tiêu đề..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary btn-block" id="apply-filters">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="articlesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="8%">Ảnh</th>
                                <th width="20%">Tiêu đề</th>
                                <th width="12%">Danh mục</th>
                                <th width="15%">Mô tả</th>
                                <th width="8%">Trạng thái</th>
                                <th width="8%">Nổi bật</th>
                                <th width="8%">Lượt xem</th>
                                <th width="10%">Ngày tạo</th>
                                <th width="6%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>
                                    @if($article->featured_image)
                                        <img src="{{ asset($article->featured_image) }}" 
                                             alt="{{ $article->title }}" 
                                             class="img-thumbnail" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; border-radius: 4px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-primary">{{ Str::limit($article->title, 40) }}</strong>
                                        @if($article->is_featured)
                                            <i class="fas fa-star text-warning ml-1" title="Bài viết nổi bật"></i>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $article->author->name ?? 'N/A' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $article->category->color ?? '#6c757d' }};">
                                        {{ $article->category->name ?? 'Chưa phân loại' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($article->description ?: strip_tags($article->content), 50) }}</span>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm status-select" 
                                            data-id="{{ $article->id }}"
                                            data-current="{{ $article->status }}">
                                        <option value="draft" {{ $article->status === 'draft' ? 'selected' : '' }}>
                                            Bản nháp
                                        </option>
                                        <option value="published" {{ $article->status === 'published' ? 'selected' : '' }}>
                                            Đã xuất bản
                                        </option>
                                        <option value="archived" {{ $article->status === 'archived' ? 'selected' : '' }}>
                                            Lưu trữ
                                        </option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm toggle-featured {{ $article->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                                            data-id="{{ $article->id }}"
                                            data-featured="{{ $article->is_featured ? 'true' : 'false' }}"
                                            title="{{ $article->is_featured ? 'Bỏ nổi bật' : 'Đặt nổi bật' }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ number_format($article->view_count) }}</span>
                                </td>
                                <td>
                                    <small>{{ $article->created_at->format('d/m/Y H:i') }}</small>
                                    @if($article->published_at)
                                        <br><small class="text-success">Xuất bản: {{ $article->published_at->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group-vertical" role="group">
                                        <a href="{{ route('admin.articles.show', $article->id) }}" 
                                           class="btn btn-info btn-sm mb-1" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                           class="btn btn-primary btn-sm mb-1" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-secondary btn-sm mb-1 duplicate-article" 
                                                data-id="{{ $article->id }}"
                                                title="Sao chép">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm delete-article" 
                                                data-id="{{ $article->id }}"
                                                data-title="{{ $article->title }}"
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Chưa có bài viết nào</h5>
                                        <p class="text-muted">Hãy tạo bài viết đầu tiên của bạn!</p>
                                        <a href="{{ route('admin.articles.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus"></i> Tạo bài viết mới
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($articles->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $articles->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Duplicate Form -->
<form id="duplicate-form" action="" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
.empty-state {
    padding: 3rem 1rem;
}

.status-select {
    font-size: 0.875rem;
}

.btn-group-vertical .btn {
    border-radius: 0.25rem !important;
}

.img-thumbnail {
    border: 2px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Apply filters
    $('#apply-filters').click(function() {
        const status = $('#status-filter').val();
        const category = $('#category-filter').val();
        const search = $('#search-input').val();
        
        const params = new URLSearchParams();
        if (status) params.append('status', status);
        if (category) params.append('category_id', category);
        if (search) params.append('search', search);
        
        window.location.href = '{{ route("admin.articles.index") }}' + (params.toString() ? '?' + params.toString() : '');
    });

    // Enter key search
    $('#search-input').keypress(function(e) {
        if (e.which === 13) {
            $('#apply-filters').click();
        }
    });

    // Toggle featured status
    $('.toggle-featured').click(function() {
        const articleId = $(this).data('id');
        const isFeatured = $(this).data('featured') === 'true';
        const button = $(this);
        
        $.ajax({
            url: `/admin/articles/${articleId}/toggle-featured`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update button
                    if (response.is_featured) {
                        button.removeClass('btn-outline-warning').addClass('btn-warning');
                        button.attr('title', 'Bỏ nổi bật');
                    } else {
                        button.removeClass('btn-warning').addClass('btn-outline-warning');
                        button.attr('title', 'Đặt nổi bật');
                    }
                    button.data('featured', response.is_featured ? 'true' : 'false');
                    
                    // Show toast
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra khi cập nhật trạng thái nổi bật!');
            }
        });
    });

    // Update status
    $('.status-select').change(function() {
        const articleId = $(this).data('id');
        const currentStatus = $(this).data('current');
        const newStatus = $(this).val();
        const select = $(this);
        
        if (newStatus === currentStatus) return;
        
        $.ajax({
            url: `/admin/articles/${articleId}/update-status`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    select.data('current', newStatus);
                    toastr.success(response.message);
                    
                    // Reload page if status changed to published
                    if (newStatus === 'published') {
                        setTimeout(() => location.reload(), 1000);
                    }
                }
            },
            error: function() {
                // Revert select value
                select.val(currentStatus);
                toastr.error('Có lỗi xảy ra khi cập nhật trạng thái!');
            }
        });
    });

    // Duplicate article
    $('.duplicate-article').click(function() {
        const articleId = $(this).data('id');
        
        Swal.fire({
            title: 'Xác nhận sao chép',
            text: 'Bạn có muốn tạo một bản sao của bài viết này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sao chép',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#duplicate-form').attr('action', `/admin/articles/${articleId}/duplicate`);
                $('#duplicate-form').submit();
            }
        });
    });

    // Delete article
    $('.delete-article').click(function() {
        const articleId = $(this).data('id');
        const articleTitle = $(this).data('title');
        
        Swal.fire({
            title: 'Xác nhận xóa',
            text: `Bạn có chắc chắn muốn xóa bài viết "${articleTitle}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form').attr('action', `/admin/articles/${articleId}`);
                $('#delete-form').submit();
            }
        });
    });
});
</script>
@endpush