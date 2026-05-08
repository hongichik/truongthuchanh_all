@extends('layouts.layout-master')

@section('title', $article->title)
@section('page_title', 'Chi tiết bài viết')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ $article->title }}
                    @if($article->is_featured)
                        <i class="fas fa-star text-warning ml-2" title="Bài viết nổi bật"></i>
                    @endif
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <div class="btn-group" role="group">
                        <button type="button" 
                                class="btn btn-success btn-sm dropdown-toggle" 
                                data-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="fas fa-cog"></i> Thao tác
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item toggle-featured" data-id="{{ $article->id }}">
                                <i class="fas fa-star {{ $article->is_featured ? 'text-warning' : '' }}"></i>
                                {{ $article->is_featured ? 'Bỏ nổi bật' : 'Đặt nổi bật' }}
                            </button>
                            <button type="button" class="dropdown-item duplicate-article" data-id="{{ $article->id }}">
                                <i class="fas fa-copy"></i> Sao chép bài viết
                            </button>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item text-danger delete-article" 
                                    data-id="{{ $article->id }}" data-title="{{ $article->title }}">
                                <i class="fas fa-trash"></i> Xóa bài viết
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Article Content -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nội dung bài viết</h4>
            </div>
            <div class="card-body">
                @if($article->featured_image)
                <div class="featured-image mb-4 text-center">
                    <img src="{{ asset($article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="img-fluid rounded shadow" 
                         style="max-height: 400px;">
                </div>
                @endif

                @if($article->description)
                <div class="article-description mb-4">
                    <h5>Mô tả:</h5>
                    <p class="text-muted">{!! $article->description !!}</p>
                </div>
                @endif

                <div class="article-content">
                    <h5>Nội dung:</h5>
                    <div class="content-body">
                        {!! $article->content !!}
                    </div>
                </div>

                @if($article->tags)
                <div class="article-tags mt-4">
                    <h6>Tags:</h6>
                    @if(is_array($article->tags))
                        @foreach($article->tags as $tag)
                            <span class="badge badge-secondary mr-1">{{ trim($tag) }}</span>
                        @endforeach
                    @else
                        @foreach(explode(',', $article->tags) as $tag)
                            <span class="badge badge-secondary mr-1">{{ trim($tag) }}</span>
                        @endforeach
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Comments or Related Articles can be added here -->
    </div>

    <!-- Article Metadata -->
    <div class="col-md-4">
        <!-- Status & Actions -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Trạng thái</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Trạng thái hiện tại:</label>
                    <select class="form-control status-select" data-id="{{ $article->id }}" data-current="{{ $article->status }}">
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
                </div>

                <div class="form-group">
                    <label>Nổi bật:</label>
                    <div>
                        <button type="button" 
                                class="btn btn-sm toggle-featured {{ $article->is_featured ? 'btn-warning' : 'btn-outline-warning' }}"
                                data-id="{{ $article->id }}"
                                data-featured="{{ $article->is_featured ? 'true' : 'false' }}">
                            <i class="fas fa-star"></i>
                            {{ $article->is_featured ? 'Bỏ nổi bật' : 'Đặt nổi bật' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Information -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin bài viết</h4>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <strong>ID:</strong> {{ $article->id }}
                </div>

                <div class="info-item mb-3">
                    <strong>Slug:</strong> 
                    <code>{{ $article->slug }}</code>
                </div>

                <div class="info-item mb-3">
                    <strong>Danh mục:</strong>
                    @if($article->category)
                        <span class="badge" style="background-color: {{ $article->category->color }};">
                            {{ $article->category->name }}
                        </span>
                    @else
                        <span class="text-muted">Chưa phân loại</span>
                    @endif
                </div>

                <div class="info-item mb-3">
                    <strong>Tác giả:</strong>
                    {{ $article->author->name ?? 'N/A' }}
                </div>

                <div class="info-item mb-3">
                    <strong>Lượt xem:</strong>
                    <span class="badge badge-info">{{ number_format($article->view_count) }}</span>
                </div>

                <div class="info-item mb-3">
                    <strong>Thời gian đọc:</strong>
                    {{ $article->reading_time }} phút
                </div>

                <div class="info-item mb-3">
                    <strong>Ngày tạo:</strong><br>
                    <small>{{ $article->created_at->format('d/m/Y H:i:s') }}</small>
                </div>

                <div class="info-item mb-3">
                    <strong>Cập nhật lần cuối:</strong><br>
                    <small>{{ $article->updated_at->format('d/m/Y H:i:s') }}</small>
                </div>

                @if($article->published_at)
                <div class="info-item mb-3">
                    <strong>Ngày xuất bản:</strong><br>
                    <small class="text-success">{{ $article->published_at->format('d/m/Y H:i:s') }}</small>
                </div>
                @endif
            </div>
        </div>

        <!-- SEO Information -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin SEO</h4>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <strong>URL:</strong><br>
                    <a href="#" class="text-primary small" target="_blank">
                        {{ url('/articles/' . $article->slug) }}
                    </a>
                </div>

                <div class="info-item mb-3">
                    <strong>Meta Title:</strong><br>
                    <small class="text-muted">{{ $article->title }}</small>
                </div>

                @if($article->description)
                <div class="info-item mb-3">
                    <strong>Meta Description:</strong><br>
                    <small class="text-muted">{{ Str::limit($article->description, 150) }}</small>
                </div>
                @endif

                @if($article->tags)
                <div class="info-item mb-3">
                    <strong>Keywords:</strong><br>
                    <small class="text-muted">
                        @if(is_array($article->tags))
                            {{ implode(', ', $article->tags) }}
                        @else
                            {{ $article->tags }}
                        @endif
                    </small>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thống kê</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-box-icon bg-primary">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="info-box-content">
                                <span class="info-box-text">Lượt xem</span>
                                <span class="info-box-number">{{ number_format($article->view_count) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-box-icon bg-success">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-box-content">
                                <span class="info-box-text">Đọc</span>
                                <span class="info-box-number">{{ $article->reading_time }}min</span>
                            </div>
                        </div>
                    </div>
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

<!-- Duplicate Form -->
<form id="duplicate-form" action="" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css?v=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css?v=1.0">
<style>
.content-body {
    line-height: 1.8;
    font-size: 1.1rem;
}

.content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.content-body blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.content-body table {
    border-collapse: collapse;
    width: 100%;
    margin: 1rem 0;
}

.content-body table td,
.content-body table th {
    border: 1px solid #dee2e6;
    padding: 0.75rem;
    text-align: left;
}

.content-body table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.featured-image img {
    border: 3px solid #dee2e6;
}

.info-item {
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0 !important;
}

.article-tags .badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.info-box {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 0.375rem;
    margin-bottom: 0.5rem;
}

.info-box-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    margin-right: 0.75rem;
}

.info-box-content {
    flex: 1;
}

.info-box-text {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 600;
    color: #6c757d;
}

.info-box-number {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
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
                    // Update all featured buttons
                    $('.toggle-featured').each(function() {
                        const btn = $(this);
                        if (response.is_featured) {
                            btn.removeClass('btn-outline-warning').addClass('btn-warning');
                            btn.html('<i class="fas fa-star"></i> Bỏ nổi bật');
                        } else {
                            btn.removeClass('btn-warning').addClass('btn-outline-warning');
                            btn.html('<i class="fas fa-star"></i> Đặt nổi bật');
                        }
                        btn.data('featured', response.is_featured ? 'true' : 'false');
                    });
                    
                    // Update header star
                    const headerStar = $('.card-title .fa-star');
                    if (response.is_featured) {
                        if (headerStar.length === 0) {
                            $('.card-title').append('<i class="fas fa-star text-warning ml-2" title="Bài viết nổi bật"></i>');
                        }
                    } else {
                        headerStar.remove();
                    }
                    
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