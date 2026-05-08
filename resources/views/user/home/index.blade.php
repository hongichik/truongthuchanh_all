@extends('layouts.app')

@section('title', 'Trang chủ - Trường TH, THCS và THPT Thực hành Sư phạm')

@php
use App\Helpers\CategoryDisplayHelper;
use Illuminate\Support\Str;
@endphp

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
                    <p class="featured-slogan">{{ $homeSettings->featured_slogan ?? 'Môi trường giáo dục hiện đại - hội nhập - nhân văn' }}</p>
                </div>
            </section>
            @endif

            <!-- Quick Links -->
            @if($homeSettings->show_quick_links ?? true)
            <section class="quick-links">
                @foreach($homeSettings->quick_links as $link)
                    @php
                        $url = $link['url'];
                    @endphp
                    <div class="quick-link-item orange" onclick="window.open('{{ $url }}', '_blank')">
                        {{ $link['title'] }}
                    </div>
                @endforeach
            </section>
            @endif

            <!-- News Sections -->
            @if(CategoryDisplayHelper::shouldShowCategories() && !empty($categoryData))
                @foreach($categoryData as $categoryInfo)
                    <section class="news-section">
                        <h3 class="section-title">
                            <a href="{{ route('articles.category', $categoryInfo['category']['slug']) }}" style="color: white; text-decoration: none;">
                                {{ $categoryInfo['config']['category_name'] }}
                            </a>
                        </h3>
                        
                        @forelse($categoryInfo['articles'] as $article)
                            <div class="news-item">
                                @if($article->featured_image)
                                    <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="{{ $article->title }}">
                                @endif
                                
                                <div class="news-content">
                                    <a href="{{ route('articles.show', [$categoryInfo['category']['slug'], $article->slug]) }}"><h4>{{ $article->title }}</h4></a> 
                                    @if($article->description)
                                        {!! $article->description !!}
                                    @else
                                        <p>{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                    @endif    
                                    <p class="news-date">
                                        <i class="far fa-clock"></i> 
                                        {{ $article->created_at->format('d') }} tháng {{ $article->created_at->format('n') }}, {{ $article->created_at->format('Y') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="news-item">
                                <div class="news-content">
                                    <p>Chưa có bài viết nào trong danh mục {{ $categoryInfo['config']['category_name'] }}.</p>
                                </div>
                            </div>
                        @endforelse
                    </section>
                @endforeach
            @else
                <!-- Fallback content nếu không có config -->
                <section class="news-section">
                    <h3 class="section-title">TIN TỨC NỔI BẬT</h3>
                    <div class="news-item">
                        <img src="{{ asset('assets/image/banner_2.jpg') }}" alt="Tin tức">
                        <div class="news-content">
                            <p>Đang cập nhật nội dung...</p>
                        </div>
                    </div>
                </section>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="sidebar">
            <!-- Notifications -->
            @if($homeSettings->show_notifications ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">THÔNG BÁO MỚI NHẤT</h3>
                @foreach($homeSettings->notifications as $notification)
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
            @if($homeSettings->show_services ?? true)
            <div class="sidebar-section">
                <h3 class="sidebar-title">LIÊN KẾT NHANH</h3>
                @foreach($homeSettings->quick_services as $service)
                    <div class="activity-item">
                        <p><strong>{{ $service['title'] }}</strong><br>
                            <a href="{{ $service['url'] }}" style="color: #2f6fed;">{{ $service['description'] }}</a>
                        </p>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection