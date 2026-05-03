<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $table = 'home_settings';

    protected $fillable = [
        'featured_title',
        'featured_subtitle', 
        'featured_image',
        'show_featured_banner',
        'header_image',
        'logo',
        'contact_info',
        'school_info',
        'social_links',
        'quick_links',
        'show_quick_links',
        'notifications',
        'show_notifications',
        'featured_activities',
        'show_activities',
        'upcoming_events',
        'show_events',
        'quick_services',
        'show_services',
        'category_display_config',
        'show_categories'
    ];

    protected $casts = [
        'quick_links' => 'array',
        'notifications' => 'array', 
        'featured_activities' => 'array',
        'upcoming_events' => 'array',
        'quick_services' => 'array',
        'contact_info' => 'array',
        'school_info' => 'array',
        'social_links' => 'array',
        'category_display_config' => 'array',
        'show_featured_banner' => 'boolean',
        'show_quick_links' => 'boolean',
        'show_notifications' => 'boolean',
        'show_activities' => 'boolean',
        'show_events' => 'boolean',
        'show_services' => 'boolean',
        'show_categories' => 'boolean'
    ];

    /**
     * Get the current home settings (singleton pattern)
     */
    public static function current()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'featured_title' => 'Trường TH, THCS và THPT Thực hành Sư phạm',
                'featured_subtitle' => 'Đại học Hạ Long - Nơi ươm mầm tương lai',
                'featured_image' => 'assets/image/banner_home.jpg',
                'header_image' => 'bg_header.jpg',
                'logo' => 'logo.png',
                'contact_info' => [
                    'phone' => '0203.3841.166',
                    'email' => 'thuchanh@uhl.edu.vn',
                    'address' => '258 Lê Thánh Tông, Phường Hồng Gai, TP. Hạ Long, Tỉnh Quảng Ninh'
                ],
                'school_info' => [
                    'name' => 'TRƯỜNG TH, THCS VÀ THPT THỰC HÀNH SƯ PHẠM',
                    'parent_organization' => 'ĐẠI HỌC HẠ LONG',
                    'short_description' => 'Nơi ươm mầm tương lai'
                ],
                'social_links' => [
                    'facebook' => '',
                    'youtube' => '',
                    'website' => ''
                ],
                'show_featured_banner' => true,
                'quick_links' => [
                    ['title' => 'Chương trình TH', 'url' => '#', 'icon' => 'fas fa-child'],
                    ['title' => 'Chương trình THCS', 'url' => '#', 'icon' => 'fas fa-user-graduate'],
                    ['title' => 'Chương trình THPT', 'url' => '#', 'icon' => 'fas fa-graduation-cap'],
                    ['title' => 'Đăng ký lớp 10', 'url' => 'dang-ky.lop10', 'icon' => 'fas fa-edit'],
                    ['title' => 'Đăng ký lớp 6', 'url' => 'dang-ky.lop6', 'icon' => 'fas fa-pen'],
                    ['title' => 'Đăng ký lớp 1', 'url' => 'dang-ky.lop1', 'icon' => 'fas fa-pencil-alt'],
                    ['title' => 'Thư viện ảnh', 'url' => '#', 'icon' => 'fas fa-images'],
                    ['title' => 'Thành tích học tập', 'url' => '#', 'icon' => 'fas fa-trophy']
                ],
                'show_quick_links' => true,
                'notifications' => [
                    [
                        'title' => 'Lịch thi cuối học kỳ II năm học 2024-2025',
                        'date' => '25 tháng 3, 2026'
                    ],
                    [
                        'title' => 'Thông báo tuyển sinh đầu cấp các khối lớp 10, 6, 1',
                        'date' => '20 tháng 3, 2026'
                    ],
                    [
                        'title' => 'Kế hoạch triển khai chương trình STEM tích hợp',
                        'date' => '15 tháng 3, 2026'
                    ],
                    [
                        'title' => 'Kế hoạch tuyển sinh đầu cấp năm học 2025-2026',
                        'date' => '10 tháng 3, 2026'
                    ]
                ],
                'show_notifications' => true,
                'featured_activities' => [
                    [
                        'title' => 'CHƯƠNG TRÌNH STEM TÍCH HỢP',
                        'description' => 'Triển khai giáo dục STEM cho học sinh THCS và THPT năm 2026',
                        'video_url' => 'https://www.youtube.com/embed/83yr4vYIJA8'
                    ],
                    [
                        'title' => 'GIAO LƯU VĂN HÓA KHU VỰC',
                        'description' => 'Chương trình giao lưu với các trường trong tỉnh Quảng Ninh',
                        'video_url' => 'https://www.youtube.com/embed/83yr4vYIJA8'
                    ],
                    [
                        'title' => 'HỌC SINH GIỎI CẤP TỈNH',
                        'description' => 'Thành tích xuất sắc của học sinh trong kỳ thi HSG 2025',
                        'video_url' => 'https://www.youtube.com/embed/83yr4vYIJA8'
                    ]
                ],
                'show_activities' => true,
                'upcoming_events' => [
                    [
                        'title' => 'Hội nghị phụ huynh cuối năm học',
                        'date' => '15 tháng 4, 2026'
                    ],
                    [
                        'title' => 'Lễ tốt nghiệp THPT khóa 2024-2026',
                        'date' => '20 tháng 4, 2026'
                    ],
                    [
                        'title' => 'Khai giảng năm học mới 2026-2027',
                        'date' => '5 tháng 9, 2026'
                    ]
                ],
                'show_events' => true,
                'quick_services' => [
                    [
                        'title' => 'Đăng ký học bạ điện tử',
                        'description' => 'học bạ điện tử →',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Tra cứu điểm thi',
                        'description' => 'Xem kết quả học tập →',
                        'url' => '#'
                    ],
                    [
                        'title' => 'Đăng ký học phí online',
                        'description' => 'Thanh toán học phí →',
                        'url' => '#'
                    ]
                ],
                'show_services' => true,
                'category_display_config' => [
                    [
                        'category_id' => null,
                        'category_name' => 'Tin tức - Thông báo',
                        'category_slug' => 'tin-tuc-thong-bao',
                        'display_order' => 1,
                        'is_visible' => true,
                        'posts_limit' => 6,
                        'show_featured_only' => true
                    ],
                    [
                        'category_id' => null,
                        'category_name' => 'Hoạt động học sinh',
                        'category_slug' => 'hoat-dong-hoc-sinh',
                        'display_order' => 2,
                        'is_visible' => true,
                        'posts_limit' => 4,
                        'show_featured_only' => true
                    ],
                    [
                        'category_id' => null,
                        'category_name' => 'Thành tích',
                        'category_slug' => 'thanh-tich',
                        'display_order' => 3,
                        'is_visible' => true,
                        'posts_limit' => 3,
                        'show_featured_only' => false
                    ]
                ],
                'show_categories' => true
            ]
        );
    }
}