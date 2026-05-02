@extends('layouts.app')

@section('title', 'Trang chủ - Trường TH, THCS và THPT Thực hành Sư phạm')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <!-- Left Content -->
        <div class="left-content">
            <!-- Featured News -->
            <section class="featured-news">
                <img src="{{ asset('assets/image/banner_home.jpg') }}" alt="Chào mừng đến với Trường Thực hành Sư phạm" class="featured-image">
                <div class="featured-overlay">
                    <h2>Trường TH, THCS và THPT Thực hành Sư phạm</h2>
                    <p>Đại học Hạ Long - Nơi ươm mầm tương lai</p>
                </div>
            </section>

            <!-- Quick Links -->
            <section class="quick-links">
                <div class="quick-link-item orange" onclick="window.open('#', '_blank')">Chương trình TH</div>
                <div class="quick-link-item orange" onclick="window.open('#', '_blank')">Chương trình THCS</div>
                <div class="quick-link-item orange" onclick="window.open('#', '_blank')">Chương trình THPT</div>
                <div class="quick-link-item orange" onclick="window.open('{{ route('dang-ky.lop10') }}', '_blank')">Đăng ký lớp 10</div>
                <div class="quick-link-item orange" onclick="window.open('{{ route('dang-ky.lop6') }}', '_blank')">Đăng ký lớp 6</div>
                <div class="quick-link-item orange" onclick="window.open('{{ route('dang-ky.lop1') }}', '_blank')">Đăng ký lớp 1</div>
                <div class="quick-link-item orange" onclick="window.open('#', '_blank')">Thư viện ảnh</div>
                <div class="quick-link-item orange" onclick="window.open('#', '_blank')">Thành tích học tập</div>
            </section>

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
            <div class="sidebar-section">
                <h3 class="sidebar-title">THÔNG BÁO MỚI NHẤT</h3>
                <div class="notification-item">
                    <p><strong>Lịch thi cuối học kỳ II năm học 2024-2025</strong></p>
                    <small>25 tháng 3, 2026</small>
                </div>
                <div class="notification-item">
                    <p><strong>Thông báo tuyển sinh đầu cấp các khối lớp 10, 6, 1</strong></p>
                    <small>20 tháng 3, 2026</small>
                </div>
                <div class="notification-item">
                    <p><strong>Kế hoạch triển khai chương trình STEM tích hợp</strong></p>
                    <small>15 tháng 3, 2026</small>
                </div>
                <div class="notification-item">
                    <p><strong>Kế hoạch tuyển sinh đầu cấp năm học 2025-2026</strong></p>
                    <small>10 tháng 3, 2026</small>
                </div>
            </div>

            <!-- Videos -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">HOẠT ĐỘNG NỔI BẬT</h3>
                <div class="video-item">
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/83yr4vYIJA8" title="CHƯƠNG TRÌNH STEM TÍCH HỢP" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <h4>CHƯƠNG TRÌNH STEM TÍCH HỢP</h4>
                    <p>Triển khai giáo dục STEM cho học sinh THCS và THPT năm 2026</p>
                </div>
                <div class="video-item">
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/83yr4vYIJA8" title="GIAO LƯU VĂN HÓA KHU VỰC" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <h4>GIAO LƯU VĂN HÓA KHU VỰC</h4>
                    <p>Chương trình giao lưu với các trường trong tỉnh Quảng Ninh</p>
                </div>
                <div class="video-item">
                    <iframe width="100%" height="auto" src="https://www.youtube.com/embed/83yr4vYIJA8" title="HỌC SINH GIỎI CẤP TỈNH" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <h4>HỌC SINH GIỎI CẤP TỈNH</h4>
                    <p>Thành tích xuất sắc của học sinh trong kỳ thi HSG 2025</p>
                </div>
            </div>

            <!-- New Events Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">SỰ KIỆN SẮP TỚI</h3>
                <div class="notification-item">
                    <p><strong>Hội nghị phụ huynh cuối năm học</strong></p>
                    <small>15 tháng 4, 2026</small>
                </div>
                <div class="notification-item">
                    <p><strong>Lễ tốt nghiệp THPT khóa 2024-2026</strong></p>
                    <small>20 tháng 4, 2026</small>
                </div>
                <div class="notification-item">
                    <p><strong>Khai giảng năm học mới 2026-2027</strong></p>
                    <small>5 tháng 9, 2026</small>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">LIÊN KẾT NHANH</h3>
                <div class="activity-item">
                    <p><strong>Đăng ký học bạ điện tử</strong><br>
                        <a href="#" style="color: #3b82f6;">học bạ điện tử →</a>
                    </p>
                </div>
                <div class="activity-item">
                    <p><strong>Tra cứu điểm thi</strong><br>
                        <a href="#" style="color: #3b82f6;">Xem kết quả học tập →</a>
                    </p>
                </div>
                <div class="activity-item">
                    <p><strong>Đăng ký học phí online</strong><br>
                        <a href="#" style="color: #3b82f6;">Thanh toán học phí →</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection