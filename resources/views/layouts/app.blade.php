<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <span><i class="fas fa-phone"></i> Hotline: 0203.3841.166</span>
                    <span><i class="fas fa-envelope"></i> Email: thuchanh@uhl.edu.vn</span>
                </div>
            </div>
        </div>

        <div class="header-main">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <img src="{{ asset('assets/image/logo.png') }}" alt="Logo Trường" class="logo">
                        <div class="school-info">
                            <h1>TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM</h1>
                            <h2>ĐẠI HỌC HẠ LONG</h2>
                        </div>
                    </div>
                    <div class="header-image">
                        <img src="{{ asset('assets/image/bg_header.jpg') }}" alt="Trường Thực hành Sư phạm - Đại học Hạ Long">
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
                        <h3 class="footer-title-desktop">Trường TH, THCS và THPT Thực hành Sư phạm - Đại học Hạ Long</h3>
                        <h3 class="footer-title-mobile">Trường TH, THCS và THPT Thực hành Sư phạm<br>Đại học Hạ Long</h3>
                        <p>Địa chỉ: 258 Lê Thánh Tông, Phường Hồng Gai, TP. Hạ Long, Tỉnh Quảng Ninh</p>
                        <p>Điện thoại: 0203.3841.166</p>
                        <p>Email: thuchanh@uhl.edu.vn</p>
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
    
    @stack('scripts')
</body>

</html>