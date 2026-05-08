@extends('layouts.layout-master')

@section('title', 'Chỉnh sửa bài viết')
@section('page_title', 'Chỉnh sửa bài viết')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa: {{ $article->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST"
                    enctype="multipart/form-data" id="article-form">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-12">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title" class="required">Tiêu đề bài viết</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $article->title) }}"
                                        placeholder="Nhập tiêu đề bài viết..." required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="form-group">
                                    <label for="slug">Slug (URL thân thiện)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $article->slug) }}"
                                            placeholder="tu-dong-tao-tu-tieu-de">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="generate-slug">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Để trống để tự động tạo từ tiêu đề</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Mô tả ngắn</label>
                                    <div class="editor-container">
                                        <textarea class="d-none" id="description" name="description"
                                            rows="4" maxlength="300">{{ old('description', $article->description) }}</textarea>
                                        <div id="description-editor" class="ck ck-editor__editable" style="min-height: 100px;">{!! old('description', $article->description) !!}</div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="form-text text-muted">Mô tả này sẽ xuất hiện trong danh sách bài viết
                                            và meta description</small>
                                        <small class="text-muted"><span id="description-count">0</span>/300 ký tự</small>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="content" class="required">Nội dung bài viết</label>
                                    <div class="editor-container">
                                        <div class="editor-toolbar mb-2">
                                        </div>
                                        <textarea class="d-none" id="content" name="content" rows="20">{{ old('content', $article->content) }}</textarea>
                                        <div id="content-editor" class="ck ck-editor__editable" style="min-height: 400px;">{!! old('content', $article->content) !!}</div>
                                    </div>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label for="tags">Tags (từ khóa)</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                        id="tags" name="tags"
                                        value="{{ old('tags', is_array($article->tags) ? implode(', ', $article->tags) : $article->tags) }}"
                                        placeholder="laravel, php, web development" data-role="tagsinput">
                                    <small class="form-text text-muted">Phân cách bằng dấu phẩy</small>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-12">
                                <!-- Publishing Options -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Tùy chọn xuất bản</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Status -->
                                        <div class="form-group">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="draft"
                                                    {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>
                                                    Bản nháp
                                                </option>
                                                <option value="published"
                                                    {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>
                                                    Xuất bản
                                                </option>
                                                <option value="scheduled"
                                                    {{ old('status', $article->status) === 'scheduled' ? 'selected' : '' }}>
                                                    Lên lịch xuất bản
                                                </option>
                                                <option value="archived"
                                                    {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>
                                                    Lưu trữ
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Published At -->
                                        <div class="form-group" id="published-at-group"
                                            style="{{ old('status', $article->status) === 'scheduled' ? 'display: block;' : 'display: none;' }}">
                                            <label for="published_at">Thời gian xuất bản</label>
                                            <input type="datetime-local"
                                                class="form-control @error('published_at') is-invalid @enderror"
                                                id="published_at" name="published_at"
                                                value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Featured -->
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_featured"
                                                    name="is_featured" value="1"
                                                    {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Bài viết nổi bật
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Article Info -->
                                        <div class="border-top pt-3 mt-3">
                                            <h6>Thông tin bài viết:</h6>
                                            <p class="small mb-1"><strong>Tạo:</strong>
                                                {{ $article->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="small mb-1"><strong>Cập nhật:</strong>
                                                {{ $article->updated_at->format('d/m/Y H:i') }}</p>
                                            <p class="small mb-1"><strong>Lượt xem:</strong>
                                                {{ number_format($article->view_count) }}</p>
                                            @if ($article->published_at)
                                                <p class="small mb-0"><strong>Xuất bản:</strong>
                                                    {{ $article->published_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Danh mục</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="category_id" class="required">Chọn danh mục</label>
                                            <select class="form-control @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mt-2">
                                            <a href="{{ route('admin.categories.create') }}"
                                                class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="fas fa-plus"></i> Tạo danh mục mới
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Ảnh đại diện</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        @if ($article->featured_image)
                                            <div class="current-image mb-3">
                                                <label class="form-label">Ảnh hiện tại:</label>
                                                <div class="text-center">
                                                    <img src="{{ asset($article->featured_image) }}"
                                                        alt="{{ $article->title }}" class="img-fluid"
                                                        style="max-height: 200px; border: 2px solid #dee2e6; border-radius: 0.375rem;">
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            id="remove-current-image">
                                                            <i class="fas fa-times"></i> Xóa ảnh hiện tại
                                                        </button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="remove_current_image"
                                                    id="remove_current_image_input" value="0">
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label
                                                for="featured_image">{{ $article->featured_image ? 'Thay đổi ảnh:' : 'Chọn ảnh:' }}</label>
                                            <input type="file"
                                                class="form-control-file @error('featured_image') is-invalid @enderror"
                                                id="featured_image" name="featured_image" accept="image/*">
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- New Image Preview -->
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <label class="form-label">Ảnh mới:</label>
                                            <div class="text-center">
                                                <img id="preview-img" alt="Preview" class="img-fluid"
                                                    style="max-height: 200px; border: 2px solid #dee2e6; border-radius: 0.375rem;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        id="remove-new-image">
                                                        <i class="fas fa-times"></i> Hủy ảnh mới
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success" name="action" value="save">
                                    <i class="fas fa-save"></i> Cập nhật bài viết
                                </button>
                                <button type="submit" class="btn btn-primary" name="action" value="save_and_continue">
                                    <i class="fas fa-save"></i> Cập nhật và tiếp tục
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css?v=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css?v=1.0">
    <link rel="stylesheet" href="{{ asset('js/ckeditor5/ckeditor5.css') }}">
    <link rel="stylesheet" href="{{ asset('js/ckeditor5/ckeditor5-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('js/ckeditor5/ckeditor5-content.css') }}">
    <style>
        .required:after {
            content: " *";
            color: red;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
            background-color: #007bff;
        }

        .current-image img,
        #preview-img {
            border: 2px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .current-image,
        #image-preview {
            text-align: center;
        }

        /* Editor Enhancements */
        .editor-container {
            position: relative;
        }

        .editor-toolbar {
            display: flex;
            gap: 5px;
            justify-content: flex-end;
        }

        .fullscreen-editor {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: white;
            z-index: 9999;
            padding: 20px;
            overflow: auto;
        }

        .fullscreen-editor .editor-toolbar {
            position: sticky;
            top: 0;
            background: white;
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .source-editor {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            min-height: 400px;
        }

        .fullscreen-editor .source-editor {
            height: calc(90vh - 100px);
        }

        /* CKEditor customizations */
        .ck-editor__editable_inline {
            min-height: 500px;
        }

        .ck-image-custom-resize-ui {
            display: none;
        }

        /* Description Editor Styles */
        .description-editor-container {
            position: relative;
        }

        .description-editor-container .ck-editor {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .description-editor-container .ck-editor__editable {
            min-height: 120px;
            max-height: 150px;
            padding: 0.75rem;
        }

        .description-warning {
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Content editor - full height */
        #content+.ck-editor .ck-editor__editable {
            min-height: 500px;
        }
    </style>
@endpush

@push('scripts')
    <script type="importmap">
    {
        "imports": {
            "ckeditor5": "{{ asset('js/ckeditor5/ckeditor5.js') }}",
            "ckeditor5/": "{{ asset('js/ckeditor5/') }}/"
        }
    }
    </script>
    <script type="module" src="{{ asset('js/ckeditor5/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing JS logic...');

            // Auto-generate slug from title
            $('#title').on('input', function() {
                if (!$('#slug').data('manual')) {
                    generateSlug();
                }
            });

            // Generate slug button
            $('#generate-slug').click(function() {
                generateSlug();
            });

            // Manual slug editing
            $('#slug').on('input', function() {
                $(this).data('manual', true);
            });

            // Function to generate slug
            function generateSlug() {
                const title = $('#title').val();
                const slug = title.toLowerCase()
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
                $('#slug').val(slug);
                $('#slug').data('manual', false);
            }

            // Status change handler
            $('#status').change(function() {
                const status = $(this).val();
                if (status === 'scheduled') {
                    $('#published-at-group').show();
                    $('#published_at').attr('required', true);
                } else {
                    $('#published-at-group').hide();
                    $('#published_at').removeAttr('required');
                }
            });

            // Remove current image
            $('#remove-current-image').click(function() {
                $(this).closest('.current-image').hide();
                $('#remove_current_image_input').val('1');
            });

            // New image preview
            $('#featured_image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-img').attr('src', e.target.result);
                        $('#image-preview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove new image
            $('#remove-new-image').click(function() {
                $('#featured_image').val('');
                $('#image-preview').hide();
            });

            // Form submission
            $('#article-form').submit(function() {
                // CKEditor contents are handled natively by main.js via event listeners on the form.
            });

            // Initialize tags input
            $('#tags').tagsinput({
                trimValue: true,
                confirmKeys: [13, 44], // Enter and comma
                maxTags: 10
            });

            // Set manual flag for slug if it was edited
            const originalSlug = $('#slug').val();
            $('#slug').data('manual', originalSlug !== '' && originalSlug !== generateSlugFromTitle($('#title')
            .val()));

            function generateSlugFromTitle(title) {
                return title.toLowerCase()
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
            }
        });
    </script>
@endpush
