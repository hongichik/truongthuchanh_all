<!DOCTYPE html>
<html lang="vi">

<head>
    @php
        $defaultTitle = trim($__env->yieldContent('title', 'Trường TH, THCS và THPT Thực hành Sư phạm - Đại học Hạ Long'));
        $defaultDescription = 'Đại học Hạ Long Trường thực hành sư phạm';
        $defaultImage = asset('assets/image/logo.png');

        if (request()->routeIs('dang-ky.lop1')) {
            $defaultTitle = 'Trang đăng ký tuyển sinh vào lớp 1 Trường thực hành sư phạm Đại học Hạ Long';
            $defaultDescription = $defaultTitle;
        } elseif (request()->routeIs('dang-ky.lop6')) {
            $defaultTitle = 'Trang đăng ký tuyển sinh vào lớp 6 Trường thực hành sư phạm Đại học Hạ Long';
            $defaultDescription = $defaultTitle;
        } elseif (request()->routeIs('dang-ky.lop10')) {
            $defaultTitle = 'Trang đăng ký tuyển sinh vào lớp 10 Trường thực hành sư phạm Đại học Hạ Long';
            $defaultDescription = $defaultTitle;
        }

        $metaTitle = trim($__env->yieldContent('meta_title', $defaultTitle));
        $metaDescription = trim(preg_replace('/\s+/', ' ', strip_tags($__env->yieldContent('meta_description', $defaultDescription))));
        $metaImage = $__env->yieldContent('meta_image', $defaultImage);
        $metaUrl = trim($__env->yieldContent('meta_url', url()->current()));
        $metaType = trim($__env->yieldContent('meta_type', 'website'));
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:site_name" content="Trường thực hành sư phạm Đại học Hạ Long">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $metaUrl }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom Badge Styles -->
    <link rel="stylesheet" href="{{ asset('css/badges.css') }}">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">

    <!-- Messenger Button -->
    <style>
        .messenger-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .messenger-btn:hover {
            transform: scale(1.1);
        }
        .messenger-btn img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-info">
                    <span><i class="fas fa-phone"></i> Hotline: 0976.690.595 - 0982.972.709</span>
                    <span><i class="fas fa-envelope"></i> Email: {{ $websiteConfig['contact_info']['email'] ?? 'thuchanh@uhl.edu.vn' }}</span>
                </div>
            </div>
        </div>

        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <img src="{{ asset('assets/image/logo.png') }}" alt="Logo Trường" class="logo">
                        <div class="school-info">
                            <h2>TRƯỜNG ĐẠI HỌC HẠ LONG</h2>
                            <h1>TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM</h1>
                        </div>
                    </div>
                    <div class="header-image">
                        <div class="image-editor-container">
                            <img src="{{ asset('assets/image/bg_header.jpg') }}?v={{ time() }}" alt="TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM - TRƯỜNG ĐẠI HỌC HẠ LONG" id="headerImage">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar">
            <div class="container">
                <!-- Mobile Menu Toggle -->
                @if($headerMenus && $headerMenus->isNotEmpty())
                    @foreach($headerMenus as $menu)
                        @if($menu->children->isNotEmpty())
                            <button class="mobile-menu-toggle">
                                <div class="dropdown">
                                    <a href="{{ $menu->url ?: '#' }}" class="nav-link" id="show-{{ $menu->slug }}">
                                        @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif {{ strtoupper($menu->name) }}
                                    </a>
                                    <div class="dropdown-content" id="{{ $menu->slug }}" style="position: fixed!important;">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}">
                                                @if($child->icon)<i class="{{ $child->icon }}"></i>@endif {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </button>
                            @break
                        @endif
                    @endforeach
                @else
                    <button class="mobile-menu-toggle">
                        <div class="dropdown">
                            <a href="#" class="nav-link" id="show-tuyen-sinh"><i class="fas fa-clipboard-list"></i>ĐĂNG KÝ TUYỂN SINH</a>
                            <div class="dropdown-content" id="tuyen-sinh" style="position: fixed!important;">
                                <a href="{{ route('dang-ky.lop10') }}"><i class="fas fa-child"></i> Đăng ký vào lớp 10</a>
                                <a href="{{ route('dang-ky.lop6') }}"><i class="fas fa-user-graduate"></i> Đăng ký vào lớp 6</a>
                                <a href="{{ route('dang-ky.lop1') }}"><i class="fas fa-graduation-cap"></i> Đăng ký vào lớp 1</a>
                            </div>
                        </div>
                    </button>
                @endif

                <!-- Desktop Menu -->
                <ul class="nav-menu" id="navMenu">
                    @if($headerMenus && $headerMenus->isNotEmpty())
                        @foreach($headerMenus as $menu)
                            <li class="{{ $menu->children->isNotEmpty() ? 'dropdown' : '' }}">
                                <a href="{{ $menu->url ?: '#' }}" class="nav-link {{ request()->url() === url($menu->url ?: '') ? 'active' : '' }}">
                                    @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif {{ strtoupper($menu->name) }}
                                </a>
                                @if($menu->children->isNotEmpty())
                                    <div class="dropdown-content">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}">
                                                @if($child->icon)<i class="{{ $child->icon }}"></i>@endif {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <!-- Fallback menu nếu không có menu trong DB -->
                        <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> TRANG CHỦ</a></li>
                        <li class="dropdown">
                            <a href="#" class="nav-link"><i class="fas fa-clipboard-list"></i> TUYỂN SINH</a>
                            <div class="dropdown-content">
                                <a href="{{ route('dang-ky.lop10') }}"><i class="fas fa-child"></i> Đăng ký vào lớp 10</a>
                                <a href="{{ route('dang-ky.lop6') }}"><i class="fas fa-user-graduate"></i> Đăng ký vào lớp 6</a>
                                <a href="{{ route('dang-ky.lop1') }}"><i class="fas fa-graduation-cap"></i> Đăng ký vào lớp 1</a>
                            </div>
                        </li>
                        <li><a href="#" class="nav-link">GIỚI THIỆU TRƯỜNG</a></li>
                        <li><a href="#" class="nav-link">CẤP TIỂU HỌC</a></li>
                        <li><a href="#" class="nav-link">CẤP THCS</a></li>
                        <li><a href="#" class="nav-link">CẤP THPT</a></li>
                        <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">LIÊN HỆ</a></li>
                    @endif
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
                        <h3 class="footer-title-desktop">TRƯỜNG ĐẠI HỌC HẠ LONG <br> TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM</h3>
                        <h3 class="footer-title-mobile">TRƯỜNG ĐẠI HỌC HẠ LONG <br> TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM</h3>
                        <p>Địa chỉ: Số 258, đường Bạch Đằng, phường Vàng Danh, tỉnh Quảng Ninh</p>
                        <p>Điện thoại: 0976.690.595 - 0982.972.709</p>
                        <p>Email: {{ $websiteConfig['contact_info']['email'] ?? 'thuchanh@uhl.edu.vn' }}</p>
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
    
    <!-- Custom CSS cho SweetAlert2 -->
    <style>
        .swal-wide {
            width: 40rem !important;
            max-width: 90% !important;
        }
        
        .swal2-popup {
            font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
            border-radius: 10px !important;
        }
        
        .swal2-title {
            font-size: 1.5rem !important;
            color: #4f6470 !important;
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
            font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
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
                        <img src="{{ asset('assets/image/bg_header.jpg') }}?v={{ time() }}" alt="Ảnh hiện tại" id="currentImagePreview">
                    </div>
                    <p><small class="text-muted">Ảnh header hiện tại</small></p>
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
    
    <!-- Nút chat Messenger -->
    <a href="https://m.me/Truongthuchanhsupham" target="_blank" rel="noopener noreferrer" class="messenger-btn" aria-label="Chat với chúng tôi qua Messenger">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg" alt="Chat Messenger">
    </a>

    @stack('scripts')
</body>

</html>