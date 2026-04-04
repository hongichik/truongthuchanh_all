<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trường TH, THCS và THPT Thực hành Sư phạm - Đại học Hạ Long')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">
    
    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-info">
                    <span><i class="fas fa-phone"></i> Hotline: {{ config('website.contact_info.phone') }}</span>
                    <span><i class="fas fa-envelope"></i> Email: {{ config('website.contact_info.email') }}</span>
                </div>
            </div>
        </div>

        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <img src="{{ asset(config('website.logo.path') . config('website.logo.current')) }}" alt="Logo Trường" class="logo">
                        <div class="school-info">
                            <h1>{{ config('website.school_info.name') }}</h1>
                            <h2>{{ config('website.school_info.parent_organization') }}</h2>
                        </div>
                    </div>
                    <div class="header-image">
                        <div class="image-editor-container">
                            <img src="{{ asset(config('website.header_image.path') . config('website.header_image.current')) }}?v={{ filemtime(public_path(config('website.header_image.path') . config('website.header_image.current'))) }}" alt="{{ config('website.school_info.name') }} - {{ config('website.school_info.parent_organization') }}" id="headerImage">
                            @if(auth()->guard('admin')->check() && (auth()->guard('admin')->user()->id == 0 || auth()->guard('admin')->user()->hasPermission('edit-home')))
                            <div class="edit-icon-overlay">
                                <button class="edit-btn" id="editHeaderBtn" title="Chỉnh sửa ảnh">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar">
            <div class="container">
                <button class="mobile-menu-toggle">
                    <div class="dropdown">
                        <a href="#" class="nav-link" id="show-tuyen-sinh"><i class="fas fa-clipboard-list"></i> TUYỂN SINH</a>
                        <div class="dropdown-content" id="tuyen-sinh" style="position: fixed!important;">
                            <a href="{{ route('dang-ky.lop10') }}"><i class="fas fa-child"></i> Đăng ký vào lớp 10</a>
                            <a href="{{ route('dang-ky.lop6') }}"><i class="fas fa-user-graduate"></i> Đăng ký vào lớp 6</a>
                            <a href="{{ route('dang-ky.lop1') }}"><i class="fas fa-graduation-cap"></i> Đăng ký vào lớp 1</a>
                        </div>
                    </div>
                </button>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> TRANG CHỦ</a></li>
                    <li class="dropdown">
                        <a href="#" class="nav-link"><i class="fas fa-clipboard-list"></i> TUYỂN SINH</a>
                        <div class="dropdown-content">
                            <a href="{{ route('dang-ky.lop10') }}"><i class="fas fa-child"></i> Đăng ký vào lớp 10</a>
                            <a href="{{ route('dang-ky.lop6') }}"><i class="fas fa-user-graduate"></i> Đăng ký vào lớp 6</a>
                            <a href="{{ route('dang-ky.lop1') }}"><i class="fas fa-graduation-cap"></i> Đăng ký vào lớp 1</a>
                        </div>
                    </li>
                    <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">GIỚI THIỆU TRƯỜNG</a></li>
                    <li><a href="#" class="nav-link">CẤP TIỂU HỌC</a></li>
                    <li><a href="#" class="nav-link">CẤP THCS</a></li>
                    <li><a href="#" class="nav-link">CẤP THPT</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">LIÊN HỆ</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <div class="footer-info">
                        <h3 class="footer-title-desktop">{{ config('website.school_info.name') }} - {{ config('website.school_info.parent_organization') }}</h3>
                        <h3 class="footer-title-mobile">{{ config('website.school_info.name') }}<br>{{ config('website.school_info.parent_organization') }}</h3>
                        <p>Địa chỉ: {{ config('website.contact_info.address') }}</p>
                        <p>Điện thoại: {{ config('website.contact_info.phone') }}</p>
                        <p>Email: {{ config('website.contact_info.email') }}</p>
                    </div>
                </div>
                <div class="footer-right">
                    <div class="footer-developer">
                        <h4>Phát triển bởi:</h4>
                        <p><strong>HongDev</strong></p>
                        <p>Trường Đại học Hạ Long</p>
                        <p>Khoa Công nghệ Thông tin</p>
                        <p style="margin-top: 10px; font-size: 12px; opacity: 0.8;">© 2026 - All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    
    <!-- Custom SweetAlert2 Configuration -->
    <script>
        // Cấu hình SweetAlert2 theme cho website
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Hàm hiển thị thông báo thành công
        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: message,
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#28a745',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-wide'
                }
            });
        }

        // Hàm hiển thị thông báo lỗi
        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra!',
                html: message.replace(/\n/g, '<br>'),
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#dc3545',
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal-wide'
                }
            });
        }

        // Hàm xác nhận hành động
        function confirmAction(title, text, confirmText = 'Có', cancelText = 'Không') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                customClass: {
                    popup: 'swal-wide'
                }
            });
        }
        
        // Hiển thị thông báo từ session
        @if(session('success_alert'))
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessAlert('{{ session('success_alert') }}');
            });
        @endif
        
        @if(session('error_alert'))
            document.addEventListener('DOMContentLoaded', function() {
                showErrorAlert('{{ session('error_alert') }}');
            });
        @endif
    </script>
    
    <!-- Custom CSS cho SweetAlert2 -->
    <style>
        .swal-wide {
            width: 40rem !important;
            max-width: 90% !important;
        }
        
        .swal2-popup {
            font-family: 'Roboto', sans-serif !important;
            border-radius: 10px !important;
        }
        
        .swal2-title {
            font-size: 1.5rem !important;
            color: #2c5530 !important;
            font-weight: 600 !important;
        }
        
        .swal2-content {
            font-size: 1rem !important;
            color: #495057 !important;
        }
        
        .swal2-confirm {
            padding: 8px 24px !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            border-radius: 5px !important;
        }
        
        .swal2-cancel {
            padding: 8px 24px !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            border-radius: 5px !important;
        }
        
        .swal2-toast {
            font-family: 'Roboto', sans-serif !important;
            font-size: 0.95rem !important;
        }
        
        .swal2-toast .swal2-title {
            font-size: 1rem !important;
            margin-bottom: 0 !important;
        }
    </style>
    
    <!-- Modal chỉnh sửa ảnh header -->
    @if(auth()->guard('admin')->check() && (auth()->guard('admin')->user()->id == 0 || auth()->guard('admin')->user()->hasPermission('edit-home')))
    <div id="imageEditModal" class="image-edit-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-camera"></i> Chỉnh sửa ảnh header</h3>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="current-image-section">
                    <h4>Ảnh hiện tại</h4>
                    <div class="current-image-preview">
                        <img src="{{ asset(config('website.header_image.path') . config('website.header_image.current')) }}?v={{ filemtime(public_path(config('website.header_image.path') . config('website.header_image.current'))) }}" alt="Ảnh hiện tại" id="currentImagePreview">
                    </div>
                    @if(config('website.header_image.last_updated'))
                    <div class="image-info">
                        <p><small><i class="fas fa-clock"></i> Cập nhật lần cuối: {{ \Carbon\Carbon::parse(config('website.header_image.last_updated'))->format('d/m/Y H:i') }}</small></p>
                        @if(config('website.header_image.updated_by_name'))
                        <p><small><i class="fas fa-user"></i> Bởi: {{ config('website.header_image.updated_by_name') }}</small></p>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="upload-section">
                    <h4>Chọn ảnh mới</h4>
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <p>Kéo thả ảnh vào đây hoặc <span class="browse-text">chọn file</span></p>
                        <p class="file-info">Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)</p>
                        <input type="file" id="imageInput" accept="image/*" style="display: none;">
                    </div>
                    
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <img id="previewImg" src="" alt="Xem trước">
                        <div class="preview-overlay">
                            <button class="change-image-btn" id="changeImageBtn">
                                <i class="fas fa-sync-alt"></i> Đổi ảnh khác
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-reset" id="resetImageBtn" title="Khôi phục ảnh mặc định">
                    <i class="fas fa-undo"></i> Khôi phục mặc định
                </button>
                <button class="btn-cancel" id="cancelBtn">Hủy bỏ</button>
                <button class="btn-save" id="saveImageBtn" disabled>
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
    @endif
    
    @stack('scripts')
</body>

</html>