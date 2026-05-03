@extends('layouts.app')

@section('title', 'Liên hệ - Trường TH, THCS và THPT Thực hành Sư phạm')

@section('content')
    <div class="container">
        <div class="content-wrapper">
            <!-- Left Content -->
            <div class="left-content" style="background: none;box-shadow: none;">
                <!-- Contact Header -->
                <div class="contact-header">
                    <h2 class="contact-title">Liên hệ với chúng tôi</h2>
                    <p class="contact-description">
                        Hãy để lại thông tin liên hệ, chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.
                    </p>
                </div>

                <div class="contact-content">
                    <div class="row">
                        <!-- Contact Form -->
                        <div class="col-lg-8">
                            <div class="contact-form-section">
                                <h3>Gửi tin nhắn cho chúng tôi</h3>
                                
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">
                                                Họ và tên <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('name') is-invalid @enderror" 
                                                id="name" 
                                                name="name" 
                                                value="{{ old('name') }}" 
                                                required
                                            >
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="email" 
                                                class="form-control @error('email') is-invalid @enderror" 
                                                id="email" 
                                                name="email" 
                                                value="{{ old('email') }}" 
                                                required
                                            >
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">
                                                Số điện thoại
                                            </label>
                                            <input 
                                                type="tel" 
                                                class="form-control @error('phone') is-invalid @enderror" 
                                                id="phone" 
                                                name="phone" 
                                                value="{{ old('phone') }}"
                                            >
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="subject" class="form-label">
                                                Tiêu đề <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('subject') is-invalid @enderror" 
                                                id="subject" 
                                                name="subject" 
                                                value="{{ old('subject') }}" 
                                                required
                                            >
                                            @error('subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">
                                            Nội dung <span class="text-danger">*</span>
                                        </label>
                                        <textarea 
                                            class="form-control @error('message') is-invalid @enderror" 
                                            id="message" 
                                            name="message" 
                                            rows="6" 
                                            required
                                        >{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane"></i>
                                        Gửi tin nhắn
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="sidebar">
                <!-- Notifications -->
                @if ($homeSettings->show_notifications ?? true)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">THÔNG BÁO MỚI NHẤT</h3>
                        @foreach ($homeSettings->notifications as $notification)
                            <div class="notification-item">
                                <p><strong>{{ $notification['title'] }}</strong></p>
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
                                <p><strong>{{ $event['title'] }}</strong></p>
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
    /* Layout Grid System */
    .content-wrapper {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin: 20px 0;
    }

    .left-content {
        min-width: 0; /* Prevent overflow */
    }

    .sidebar {
        min-width: 300px;
    }

    /* Contact Header */
    .contact-header {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .contact-title {
        font-size: 24px;
        font-weight: bold;
        margin: 0 0 8px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .contact-description {
        margin: 0;
        font-size: 16px;
        opacity: 0.9;
    }

    /* Contact Content */
    .contact-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    /* Contact Form */
    .contact-form-section h3 {
        color: #1e293b;
        margin-bottom: 20px;
        font-size: 20px;
        font-weight: 600;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 10px;
    }

    .contact-form .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .contact-form .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .contact-form .form-control:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
    }

    .contact-form .btn-primary {
        background: #22c55e;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .contact-form .btn-primary:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
    }

    /* Contact Info */
    .contact-info-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 12px;
        height: fit-content;
    }

    .contact-info-section h3 {
        color: #1e293b;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 600;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
    }

    .contact-info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        padding: 15px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .contact-info-item:last-child {
        margin-bottom: 0;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: #22c55e;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .contact-icon i {
        color: white;
        font-size: 16px;
    }

    .contact-details h4 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: #1e293b;
    }

    .contact-details p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }

    .contact-details a {
        color: #22c55e;
        text-decoration: none;
    }

    .contact-details a:hover {
        text-decoration: underline;
    }

    /* Map Section */
    .map-section {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #e5e7eb;
    }

    .map-section h3 {
        color: #1e293b;
        margin-bottom: 20px;
        font-size: 20px;
        font-weight: 600;
    }

    .map-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar Styles */
    .sidebar-section {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .sidebar-title {
        background: #22c55e;
        color: white;
        margin: -20px -20px 15px -20px;
        padding: 12px 20px;
        border-radius: 12px 12px 0 0;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .notification-item, .activity-item {
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 0;
    }

    .notification-item:last-child, .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .video-item {
        margin-bottom: 20px;
    }

    .video-item:last-child {
        margin-bottom: 0;
    }

    .video-item iframe {
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .video-item h4 {
        font-size: 14px;
        margin-bottom: 8px;
        color: #1e293b;
    }

    .video-item p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #f0fdf4;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .sidebar {
            min-width: auto;
            order: 2;
        }
        
        .left-content {
            order: 1;
        }
        
        .contact-header {
            padding: 20px;
            margin-bottom: 20px;
        }

        .contact-title {
            font-size: 20px;
        }

        .contact-content {
            padding: 20px;
        }

        .contact-info-section {
            margin-top: 25px;
            padding: 20px;
        }

        .map-section {
            margin-top: 20px;
        }
    }
</style>
@endpush