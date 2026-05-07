@extends('layouts.app')

@section('title', $article->title . ' - Trường TH, THCS và THPT Thực hành Sư phạm')
@section('meta_title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->description ?: $article->content), 160))
@section('meta_image', $article->featured_image_url)

@php
use App\Helpers\CategoryDisplayHelper;
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <div class="content-wrapper">
        <!-- Left Content -->
        <div class="left-content">
            <!-- Article Content -->
            <article class="article-detail">
                <!-- Article Header -->
                <header class="article-header">
                    <div class="article-category">
                        <a href="{{ route('articles.category', $article->category->slug) }}" class="category-link">
                            {{ $article->category->name }}
                        </a>
                    </div>
                    
                    <h1 class="article-title">{{ $article->title }}</h1>    
                    <div class="article-meta">
                        <div class="meta-left">
                            <span class="meta-item">
                                <i class="far fa-calendar"></i>
                                {{ $article->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                            </span>
                            @if($article->view_count > 0)
                                <span class="meta-item">
                                    <i class="far fa-eye"></i>
                                    {{ number_format($article->view_count) }} lượt xem
                                </span>
                            @endif
                        </div>
                        
                        <div class="meta-right">
                            @if($article->is_featured)
                                <span class="featured-badge">Bài viết nổi bật</span>
                            @endif
                        </div>
                    </div>
                </header>
                <div class="article-description">
                    {!! $article->description !!}
                </div>
                <!-- Article Body -->
                <div class="article-body">
                    {!! $article->content !!}
                </div>

                <!-- Article Tags -->
                @if($article->tags)
                    <div class="article-tags">
                        <h4>Từ khóa:</h4>
                        <div class="tags-list">
                            @if(is_array($article->tags))
                                @foreach($article->tags as $tag)
                                    <span class="tag">{{ trim($tag) }}</span>
                                @endforeach
                            @else
                                @foreach(explode(',', $article->tags) as $tag)
                                    <span class="tag">{{ trim($tag) }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Social Share -->
                <div class="social-share">
                    <h4>Chia sẻ bài viết:</h4>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                           target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="mailto:?subject={{ urlencode($article->title) }}&body={{ urlencode(url()->current()) }}" 
                           class="share-btn email">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                </div>
            </article>
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

@push('styles')
<style>
/* Article detail page specific styles */
.breadcrumb-section {
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.breadcrumb {
    margin: 0;
    background: none;
    padding: 0;
}

.article-detail {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.article-header {
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 25px;
    margin-bottom: 30px;
}

.article-description {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-left: 4px solid #3b82f6;
    padding: 20px 25px;
    margin: 25px 0 30px 0;
    border-radius: 8px;
    font-size: 18px;
    line-height: 1.7;
    color: #475569;
    font-style: italic;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    position: relative;
}

.article-description::before {
    content: "";
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 20px;
    opacity: 0.6;
}

.article-description p:last-child {
    margin-bottom: 0;
}

.article-description strong {
    color: #334155;
    font-weight: 600;
}

.article-category .category-link {
    background: #22c55e;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 15px;
    transition: background 0.3s;
}

.article-category .category-link:hover {
    background: #16a34a;
}

.article-title {
    font-size: 32px;
    font-weight: bold;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 15px;
}

.article-excerpt {
    font-size: 18px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 20px;
    font-style: italic;
}

.article-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.meta-left {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #64748b;
    font-size: 14px;
}

.meta-item i {
    color: #94a3b8;
}

.featured-badge {
    background: #ef4444;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.article-featured-image {
    margin-bottom: 30px;
    text-align: center;
}

.article-featured-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.article-body {
    font-size: 16px;
    line-height: 1.8;
    color: #374151;
}

.article-body p {
    margin-bottom: 20px;
}

.article-body h1, .article-body h2, .article-body h3, .article-body h4 {
    margin-top: 30px;
    margin-bottom: 15px;
    color: #1e293b;
}

.article-body ul, .article-body ol {
    margin-bottom: 20px;
    padding-left: 30px;
}

.article-body li {
    margin-bottom: 8px;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.article-tags {
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

.article-tags h4 {
    margin-bottom: 15px;
    color: #374151;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag {
    background: #f1f5f9;
    color: #64748b;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 13px;
}

.social-share {
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

.social-share h4 {
    margin-bottom: 15px;
    color: #374151;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
}

.share-btn.facebook {
    background: #1877f2;
    color: white;
}

.share-btn.twitter {
    background: #1da1f2;
    color: white;
}

.share-btn.email {
    background: #6b7280;
    color: white;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.related-articles {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.related-articles .section-title {
    background: #6366f1;
    color: white;
    padding: 12px 20px;
    margin: -30px -30px 25px -30px;
    border-radius: 12px 12px 0 0;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.related-item {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.related-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.related-image {
    height: 150px;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-item:hover .related-image img {
    transform: scale(1.05);
}

.related-content {
    padding: 15px;
}

.related-content h3 {
    margin: 0 0 10px 0;
    font-size: 16px;
    line-height: 1.4;
}

.related-content h3 a {
    color: #1e40af;
    text-decoration: none;
    transition: color 0.3s;
}

.related-content h3 a:hover {
    color: #3b82f6;
}

.related-date {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .article-detail {
        padding: 20px;
    }
    
    .article-title {
        font-size: 24px;
    }
    
    .article-excerpt {
        font-size: 16px;
    }
    
    .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
    
    .share-buttons {
        flex-direction: column;
    }
}
</style>
@endpush