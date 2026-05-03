@extends('layouts.app')

@section('title', 'Trang chủ - Trường TH, THCS và THPT Thực hành Sư phạm')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <!-- Left Content -->
        <div class="left-content">
            <!-- Featured News -->
            @if($homeSettings->show_featured_banner ?? true)
            <section class="featured-news">
                @if(str_starts_with($homeSettings->featured_image, 'http'))
                    <img src="{{ $homeSettings->featured_image }}" alt="{{ $homeSettings->featured_title }}" class="featured-image">
                @elseif(str_starts_with($homeSettings->featured_image, 'storage/'))
                    <img src="{{ asset($homeSettings->featured_image) }}" alt="{{ $homeSettings->featured_title }}" class="featured-image">
                @else
                    <img src="{{ asset($homeSettings->featured_image) }}" alt="{{ $homeSettings->featured_title }}" class="featured-image">
                @endif
                <div class="featured-overlay">
                    <h2>{{ $homeSettings->featured_title }}</h2>
                    <p>{{ $homeSettings->featured_subtitle }}</p>
                </div>
            </section>
            @endif

            <!-- Quick Links -->
            @if($homeSettings->show_quick_links ?? true)
            <section class="quick-links">
                @foreach($homeSettings->quick_links as $link)
                    @php
                        $url = $link['url'];
                        // Check if it's a route name
                        if($url !== '#' && !str_starts_with($url, 'http') && !str_starts_with($url, '/')) {
                            $url = route($url);
                        }
                    @endphp
                    <div class="quick-link-item orange" onclick="window.open('{{ $url }}', '_blank')">
                        {{ $link['title'] }}
                    </div>
                @endforeach
            </section>
            @endif

            <!-- News Sections -->
            <section class="news-section">
                <h3 class="section-title">Sự kiện nhà trường</h3>
                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Thông báo">
                    <a href="#" class="news-content">
                        <h4>Thông báo về việc tổ chức các hoạt động giáo dục năm học 2024-2025</h4>
                        <p>Nhà trường thông báo kế hoạch tổ chức các hoạt động giáo dục, ngoại khóa cho học sinh các cấp Tiểu học, THCS và THPT trong năm học 2024-2025.</p>
                        <ul>
                            <li>Lịch thi học kỳ II được điều chỉnh phù hợp với tình hình thời tiết</li>
                            <li>Các hoạt động ngoại khóa được tăng cường để phát triển toàn diện học sinh</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 25 tháng 3, 2026</p>
                    </a>
                </div>

                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Tuyển sinh">
                    <div href="#" class="news-content">
                        <a href="">
                        <h4>Thông báo tuyển sinh đầu cấp năm học 2025-2026</h4>    
                        </a> 
                        <p>Trường thông báo kế hoạch tuyển sinh lớp 10, lớp 6 và lớp 1 cho năm học 2025-2026. Phụ huynh có thể đăng ký trực tuyến.</p>
                        <ul>
                            <li><strong>Lớp 10:</strong> <a href="{{ route('dang-ky.lop10') }}" style="color: #22c55e; font-weight: bold;">Đăng ký ngay →</a></li>
                            <li><strong>Lớp 6:</strong> <a href="{{ route('dang-ky.lop6') }}" style="color: #22c55e; font-weight: bold;">Đăng ký ngay →</a></li>
                            <li><strong>Lớp 1:</strong> <a href="{{ route('dang-ky.lop1') }}" style="color: #22c55e; font-weight: bold;">Đăng ký ngay →</a></li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 25 tháng 3, 2026</p>
                    </div>
                </div>
            </section>

            <section class="news-section">
                <h3 class="section-title">HOẠT ĐỘNG NỔI BẬT</h3>
                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Hoạt động">
                    <a href="#" class="news-content">
                        <h4>Chương trình giao lưu văn hóa với các trường bạn trong khu vực</h4>
                        <p>Học sinh các cấp tham gia chương trình giao lưu văn hóa, thể thao với các trường học trong tỉnh Quảng Ninh.</p>
                        <ul>
                            <li>Thi đấu thể thao giữa các trường khu vực Đông Bắc</li>
                            <li>Trình diễn văn nghệ đặc sắc của từng địa phương</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 18 tháng 3, 2026</p>
                    </a>
                </div>

                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Học tập">
                    <a href="#" class="news-content">
                        <h4>Triển khai chương trình STEM tích hợp cho học sinh THCS và THPT</h4>
                        <p>Nhà trường triển khai chương trình giáo dục STEM nhằm phát triển tư duy sáng tạo, khoa học cho học sinh.</p>
                        <ul>
                            <li>Trang bị phòng thí nghiệm hiện đại cho các môn khoa học</li>
                            <li>Đào tạo giáo viên phương pháp giảng dạy STEM</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 15 tháng 3, 2026</p>
                    </a>
                </div>
            </section>

            <section class="news-section">
                <h3 class="section-title">THÀNH TÍCH HỌC SINH</h3>
                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Thành tích">
                    <a href="#" class="news-content">
                        <h4>Học sinh đạt giải cao trong kỳ thi học sinh giỏi cấp tỉnh</h4>
                        <p>Chúc mừng các em học sinh đạt thành tích xuất sắc trong kỳ thi học sinh giỏi cấp tỉnh Quảng Ninh năm học 2024-2025.</p>
                        <ul>
                            <li>15 giải nhất, nhì, ba các môn Toán, Văn, Anh văn cấp THCS</li>
                            <li>8 giải trong các môn Lý, Hóa, Sinh cấp THPT</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 10 tháng 3, 2026</p>
                    </a>
                </div>

                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Khen thưởng">
                    <a href="#" class="news-content">
                        <h4>Trường được công nhận đạt chuẩn Quốc gia mức độ I</h4>
                        <p>Trường chính thức được Bộ Giáo dục và Đào tạo công nhận đạt chuẩn Quốc gia mức độ I cho tất cả các cấp học.</p>
                        <ul>
                            <li>Đánh giá cao về chất lượng cơ sở vật chất và đội ngũ giáo viên</li>
                            <li>Kết quả học tập của học sinh luôn trong tốp đầu tỉnh</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 5 tháng 3, 2026</p>
                    </a>
                </div>
            </section>

            <section class="news-section">
                <h3 class="section-title">CHƯƠNG TRÌNH GIÁO DỤC</h3>
                <div class="news-item">
                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Giáo dục">
                    <a href="#" class="news-content">
                        <h4>Áp dụng chương trình giáo dục phổ thông mới 2018 toàn diện</h4>
                        <p>Trường triển khai thành công chương trình giáo dục phổ thông mới cho tất cả các khối lớp từ 1 đến 12.</p>
                        <ul>
                            <li>Đổi mới phương pháp giảng dạy theo hướng phát huy tính tích cực của học sinh</li>
                            <li>Trang bị đầy đủ tài liệu, thiết bị dạy học hiện đại</li>
                        </ul>
                        <p class="news-date"><i class="far fa-clock"></i> 1 tháng 3, 2026</p>
                    </a>
                </div>
            </section>
        </div>

        <!-- Right Sidebar -->
        <div class="sidebar">
            <!-- Notifications -->
            @if($homeSettings->show_notifications ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">THÔNG BÁO MỚI NHẤT</h3>
                @foreach($homeSettings->notifications as $notification)
                    <div class="notification-item">
                        <p><strong>{{ $notification['title'] }}</strong></p>
                        <small>{{ $notification['date'] }}</small>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Videos -->
            @if($homeSettings->show_activities ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">HOẠT ĐỘNG NỔI BẬT</h3>
                @foreach($homeSettings->featured_activities as $activity)
                    <div class="video-item">
                        <iframe width="100%" height="auto" 
                                src="{{ $activity['video_url'] }}" 
                                title="{{ $activity['title'] }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen></iframe>
                        <h4>{{ $activity['title'] }}</h4>
                        <p>{{ $activity['description'] }}</p>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- New Events Section -->
            @if($homeSettings->show_events ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">SỰ KIỆN SẮP TỚI</h3>
                @foreach($homeSettings->upcoming_events as $event)
                    <div class="notification-item">
                        <p><strong>{{ $event['title'] }}</strong></p>
                        <small>{{ $event['date'] }}</small>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Quick Links -->
            @if($homeSettings->show_services ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">LIÊN KẾT NHANH</h3>
                @foreach($homeSettings->quick_services as $service)
                    <div class="activity-item">
                        <p><strong>{{ $service['title'] }}</strong><br>
                            <a href="{{ $service['url'] }}" style="color: #3b82f6;">{{ $service['description'] }}</a>
                        </p>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection