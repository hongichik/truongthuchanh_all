@extends('layouts.app')

@section('title', $category->name . ' - Trường TH, THCS và THPT Thực hành Sư phạm')

@php
    use App\Helpers\CategoryDisplayHelper;
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="container">
        <div class="content-wrapper">
            <!-- Left Content -->
            <div class="left-content">
            <div class="category-header-simple">
                <h2 class="category-title-main">{{ $category->name }}</h2>
            </div>
                <!-- Articles Grid -->
                <section class="articles-grid">
                    @forelse($articles as $article)
                        <div class="news-item" style="padding: 10px; padding-top:0; border-bottom: 1px solid #eee;">
                            @if ($article->featured_image)
                                <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}">
                            @else
                                <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="{{ $article->title }}">
                            @endif

                            <div class="news-content">
                                <a href="{{ route('article.show', [$category->slug, $article->slug]) }}">
                                    <h4>{{ $article->title }}</h4>
                                </a>
                                @if ($article->description)
                                    {!! $article->description !!}
                                @else
                                    <p>{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                @endif
                                <p class="news-date">
                                    <i class="far fa-clock"></i>
                                    {{ $article->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d') }} tháng
                                    {{ $article->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('n') }},
                                    {{ $article->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="no-articles">
                            <div class="no-articles-content">
                                <i class="fas fa-newspaper"></i>
                                <h3>Chưa có bài viết nào</h3>
                                <p>Danh mục này hiện chưa có bài viết nào được xuất bản.</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
                            </div>
                        </div>
                    @endforelse
                </section>

                <!-- Pagination -->
                @if ($articles->hasPages())
                    {{ $articles->links('pagination.custom') }}
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="sidebar">
                <!-- Notifications -->
                @if ($homeSettings->show_notifications ?? true)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">THÔNG BÁO MỚI NHẤT</h3>
                        @foreach ($homeSettings->notifications as $notification)
                            <div class="notification-item">
                                <p>
                                    @if(!empty($notification['url']))
                                        <a href="{{ $notification['url'] }}" class="notification-link"><strong>{{ $notification['title'] }}</strong></a>
                                    @else
                                        <strong>{{ $notification['title'] }}</strong>
                                    @endif
                                </p>
                                <small>{{ $notification['date'] }}</small>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Videos -->
                @if ($homeSettings->show_activities ?? true)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">HOẠT ĐỘNG NỔI BẬT</h3>
                        @foreach ($homeSettings->featured_activities as $activity)
                            <div class="video-item">
                                <iframe width="100%" height="auto" src="{{ $activity['video_url'] }}"
                                    title="{{ $activity['title'] }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                <h4>{{ $activity['title'] }}</h4>
                                <p>{{ $activity['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- New Events Section -->
                @if ($homeSettings->show_events ?? true)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">SỰ KIỆN SẮP TỚI</h3>
                        @foreach ($homeSettings->upcoming_events as $event)
                            <div class="notification-item">
                                <p>
                                    @if(!empty($event['url']))
                                        <a href="{{ $event['url'] }}" class="notification-link"><strong>{{ $event['title'] }}</strong></a>
                                    @else
                                        <strong>{{ $event['title'] }}</strong>
                                    @endif
                                </p>
                                <small>{{ $event['date'] }}</small>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Quick Links -->
                @if ($homeSettings->show_services ?? true)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">LIÊN KẾT NHANH</h3>
                        @foreach ($homeSettings->quick_services as $service)
                            <div class="activity-item">
                                <p><strong>{{ $service['title'] }}</strong><br>
                                    <a href="{{ $service['url'] }}"
                                        style="color: #3b82f6;">{{ $service['description'] }}</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Category Header */
        .category-header-simple {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .category-title-main {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .category-stats {
            font-size: 14px;
            opacity: 0.9;
        }

        .total-articles {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 15px;
            font-weight: 500;
        }

        .breadcrumb-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb {
            margin: 0;
            background: none;
            padding: 0;
        }

        .category-header {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .category-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .category-description {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .category-stats {
            font-size: 14px;
            opacity: 0.8;
        }

        .total-articles {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 15px;
        }

        .articles-grid {
            display: grid;
                grid-template-columns: 1fr;
                gap: 20px;
        }

        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .article-card:hover .article-image img {
            transform: scale(1.05);
        }

        .featured-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .article-content {
            padding: 20px;
        }

        .article-title a {
            color: #1e40af;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
            display: block;
            margin-bottom: 10px;
        }

        .article-title a:hover {
            color: #3b82f6;
        }

        .article-excerpt {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #888;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .no-articles {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
        }

        .no-articles-content i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-articles-content h3 {
            color: #666;
            margin-bottom: 10px;
        }

        .no-articles-content p {
            color: #888;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #22c55e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #16a34a;
        }

        .pagination-wrapper {
            text-align: center;
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .articles-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .category-header-simple {
                padding: 20px;
                margin-bottom: 20px;
            }

            .category-title-main {
                font-size: 20px;
            }

            .category-header {
                padding: 20px;
            }
            
            /* Mobile Pagination */
            .pagination-wrapper .pagination {
                flex-wrap: wrap;
                gap: 4px;
            }
            
            .pagination-wrapper .page-link {
                min-width: 35px;
                height: 35px;
                font-size: 14px;
            }
            
            .pagination-info {
                font-size: 12px;
                margin-top: 10px;
            }
        }
    </style>
@endpush
