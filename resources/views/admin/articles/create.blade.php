@extends('layouts.layout-master')

@section('title', 'Tạo bài viết mới')
@section('page_title', 'Tạo bài viết mới')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm bài viết mới</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
                    id="article-form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-12">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title" class="required">Tiêu đề bài viết</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}"
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
                                            id="slug" name="slug" value="{{ old('slug') }}"
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
                                            rows="4" maxlength="300">{{ old('description') }}</textarea>
                                        <div id="description-editor" class="ck ck-editor__editable" style="min-height: 100px;">{!! old('description') !!}</div>
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
                                        <textarea class="d-none" id="content" name="content" rows="20">{{ old('content') }}</textarea>
                                        <div id="content-editor" class="ck ck-editor__editable" style="min-height: 400px;">{!! old('content') !!}</div>
                                    </div>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label for="tags">Tags (từ khóa)</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                        id="tags" name="tags" value="{{ old('tags') }}"
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
                                                    {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                                    Bản nháp
                                                </option>
                                                <option value="published"
                                                    {{ old('status') === 'published' ? 'selected' : '' }}>
                                                    Xuất bản ngay
                                                </option>
                                                <option value="scheduled"
                                                    {{ old('status') === 'scheduled' ? 'selected' : '' }}>
                                                    Lên lịch xuất bản
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Published At -->
                                        <div class="form-group" id="published-at-group" style="display: none;">
                                            <label for="published_at">Thời gian xuất bản</label>
                                            <input type="datetime-local"
                                                class="form-control @error('published_at') is-invalid @enderror"
                                                id="published_at" name="published_at" value="{{ old('published_at') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Featured -->
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_featured"
                                                    name="is_featured" value="1"
                                                    {{ old('is_featured') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Bài viết nổi bật
                                                </label>
                                            </div>
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
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        <div class="form-group">
                                            <input type="file"
                                                class="form-control-file @error('featured_image') is-invalid @enderror"
                                                id="featured_image" name="featured_image" accept="image/*">
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Image Preview -->
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-img" alt="Preview" class="img-fluid"
                                                style="max-height: 200px;">
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                                id="remove-image">
                                                <i class="fas fa-times"></i> Xóa ảnh
                                            </button>
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
                                    <i class="fas fa-save"></i> Lưu bài viết
                                </button>
                                <button type="submit" class="btn btn-primary" name="action" value="save_and_continue">
                                    <i class="fas fa-save"></i> Lưu và tiếp tục chỉnh sửa
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

        #image-preview {
            text-align: center;
        }

        #preview-img {
            border: 2px solid #dee2e6;
            border-radius: 0.375rem;
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

        /* Content editor & styles */
        .ck.ck-toolbar {
            border: 1px solid #999 !important;
            border-bottom: none !important;
            border-radius: 0.375rem 0.375rem 0 0 !important;
            background-color: #f8f9fa !important;
        }
        
        .ck.ck-editor__editable {
            border: 1px solid #999 !important;
            border-radius: 0 0 0.375rem 0.375rem !important;
            padding: 1rem 1.5rem !important;
        }

        .ck.ck-editor__editable.ck-focused {
            border-color: #80bdff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
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

            // Image preview
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

            // Remove image
            $('#remove-image').click(function() {
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
        });
    </script>
@endpush
