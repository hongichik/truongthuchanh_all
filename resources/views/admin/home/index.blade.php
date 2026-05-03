@extends('layouts.layout-master')

@section('title', 'Quản lý Trang chủ')
@section('page_title', 'Quản lý Trang chủ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-home mr-1"></i>
                    Cấu hình Trang chủ
                </h3>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="homeSettingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button" role="tab">
                            <i class="fas fa-image"></i> Banner chính
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="quick-links-tab" data-bs-toggle="tab" data-bs-target="#quick-links" type="button" role="tab">
                            <i class="fas fa-link"></i> Liên kết nhanh
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                            <i class="fas fa-bell"></i> Thông báo mới nhất
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab">
                            <i class="fas fa-video"></i> Hoạt động nổi bật
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab">
                            <i class="fas fa-calendar"></i> Sự kiện sắp tới
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">
                            <i class="fas fa-cogs"></i> Dịch vụ nhanh
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">
                            <i class="fas fa-tags"></i> Quản lý danh mục
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="website-config-tab" data-bs-toggle="tab" data-bs-target="#website-config" type="button" role="tab">
                            <i class="fas fa-wrench"></i> Cấu hình website
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-3" id="homeSettingsTabContent">
                    <!-- Featured News Tab -->
                    <div class="tab-pane fade show active" id="featured" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-image text-primary"></i> 
                                    Hiển thị Banner chính
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị banner chính trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_featured_banner" 
                                       data-section="featured_banner"
                                       {{ $settings->show_featured_banner ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_featured_banner"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.featured.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="featured_title" class="required">Tiêu đề chính</label>
                                        <input type="text" class="form-control @error('featured_title') is-invalid @enderror" 
                                               id="featured_title" name="featured_title" 
                                               value="{{ old('featured_title', $settings->featured_title) }}" 
                                               placeholder="Tiêu đề hiển thị trên banner" required>
                                        @error('featured_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="featured_subtitle" class="required">Tiêu đề phụ</label>
                                        <input type="text" class="form-control @error('featured_subtitle') is-invalid @enderror" 
                                               id="featured_subtitle" name="featured_subtitle" 
                                               value="{{ old('featured_subtitle', $settings->featured_subtitle) }}" 
                                               placeholder="Mô tả ngắn gọn" required>
                                        @error('featured_subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="featured_image">Hình ảnh banner</label>
                                        <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" 
                                               id="featured_image" name="featured_image" accept="image/*">
                                        <small class="form-text text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</small>
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Preview hiện tại</label>
                                    <div class="current-banner-preview">
                                        @if(str_starts_with($settings->featured_image, 'http'))
                                            <img src="{{ $settings->featured_image }}" alt="Current banner" class="img-fluid rounded">
                                        @elseif(str_starts_with($settings->featured_image, 'storage/'))
                                            <img src="{{ asset($settings->featured_image) }}" alt="Current banner" class="img-fluid rounded">
                                        @else
                                            <img src="{{ asset($settings->featured_image) }}" alt="Current banner" class="img-fluid rounded">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật Banner
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Links Tab -->
                    <div class="tab-pane fade" id="quick-links" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-link text-primary"></i> 
                                    Hiển thị Liên kết nhanh
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị section liên kết nhanh trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_quick_links" 
                                       data-section="quick_links"
                                       {{ $settings->show_quick_links ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_quick_links"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.quick-links.update') }}" method="POST">
                            @csrf
                            <div id="quick-links-container">
                                @if($settings->quick_links && count($settings->quick_links) > 0)
                                    @foreach($settings->quick_links as $index => $link)
                                        <div class="quick-link-item border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Tiêu đề</label>
                                                        <input type="text" class="form-control" 
                                                               name="quick_links[{{ $index }}][title]" 
                                                               value="{{ $link['title'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Liên kết</label>
                                                        <input type="text" class="form-control" 
                                                               name="quick_links[{{ $index }}][url]" 
                                                               value="{{ $link['url'] }}" 
                                                               placeholder="# hoặc tên route hoặc URL đầy đủ" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-quick-link">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-success" id="add-quick-link">
                                    <i class="fas fa-plus"></i> Thêm liên kết
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật liên kết nhanh
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-bell text-primary"></i> 
                                    Hiển thị Thông báo mới nhất
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị section thông báo trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_notifications" 
                                       data-section="notifications"
                                       {{ $settings->show_notifications ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_notifications"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.notifications.update') }}" method="POST">
                            @csrf
                            <div id="notifications-container">
                                @if($settings->notifications && count($settings->notifications) > 0)
                                    @foreach($settings->notifications as $index => $notification)
                                        <div class="notification-item border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Tiêu đề thông báo</label>
                                                        <input type="text" class="form-control" 
                                                               name="notifications[{{ $index }}][title]" 
                                                               value="{{ $notification['title'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Ngày</label>
                                                        <input type="text" class="form-control" 
                                                               name="notifications[{{ $index }}][date]" 
                                                               value="{{ $notification['date'] }}" 
                                                               placeholder="1 tháng 1, 2026" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-notification">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-success" id="add-notification">
                                    <i class="fas fa-plus"></i> Thêm thông báo
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật thông báo
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Activities Tab -->
                    <div class="tab-pane fade" id="activities" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-video text-primary"></i> 
                                    Hiển thị Hoạt động nổi bật
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị section hoạt động trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_activities" 
                                       data-section="activities"
                                       {{ $settings->show_activities ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_activities"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.activities.update') }}" method="POST">
                            @csrf
                            <div id="activities-container">
                                @if($settings->featured_activities && count($settings->featured_activities) > 0)
                                    @foreach($settings->featured_activities as $index => $activity)
                                        <div class="activity-item border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tiêu đề</label>
                                                        <input type="text" class="form-control" 
                                                               name="featured_activities[{{ $index }}][title]" 
                                                               value="{{ $activity['title'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mô tả</label>
                                                        <textarea class="form-control" rows="2"
                                                                  name="featured_activities[{{ $index }}][description]" 
                                                                  required>{{ $activity['description'] }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>URL Video</label>
                                                        <input type="url" class="form-control" 
                                                               name="featured_activities[{{ $index }}][video_url]" 
                                                               value="{{ $activity['video_url'] }}" 
                                                               placeholder="https://www.youtube.com/embed/..." required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-activity">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-success" id="add-activity">
                                    <i class="fas fa-plus"></i> Thêm hoạt động
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật hoạt động nổi bật
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Events Tab -->
                    <div class="tab-pane fade" id="events" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-calendar text-primary"></i> 
                                    Hiển thị Sự kiện sắp tới
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị section sự kiện trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_events" 
                                       data-section="events"
                                       {{ $settings->show_events ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_events"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.events.update') }}" method="POST">
                            @csrf
                            <div id="events-container">
                                @if($settings->upcoming_events && count($settings->upcoming_events) > 0)
                                    @foreach($settings->upcoming_events as $index => $event)
                                        <div class="event-item border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Tên sự kiện</label>
                                                        <input type="text" class="form-control" 
                                                               name="upcoming_events[{{ $index }}][title]" 
                                                               value="{{ $event['title'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Thời gian</label>
                                                        <input type="text" class="form-control" 
                                                               name="upcoming_events[{{ $index }}][date]" 
                                                               value="{{ $event['date'] }}" 
                                                               placeholder="15 tháng 4, 2026" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-event">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-success" id="add-event">
                                    <i class="fas fa-plus"></i> Thêm sự kiện
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật sự kiện sắp tới
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Services Tab -->
                    <div class="tab-pane fade" id="services" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-light">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-cogs text-primary"></i> 
                                    Hiển thị Dịch vụ nhanh
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị section dịch vụ trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_services" 
                                       data-section="services"
                                       {{ $settings->show_services ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_services"></label>
                            </div>
                        </div>

                        <form action="{{ route('admin.home.services.update') }}" method="POST">
                            @csrf
                            <div id="services-container">
                                @if($settings->quick_services && count($settings->quick_services) > 0)
                                    @foreach($settings->quick_services as $index => $service)
                                        <div class="service-item border p-3 mb-3 rounded">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tên dịch vụ</label>
                                                        <input type="text" class="form-control" 
                                                               name="quick_services[{{ $index }}][title]" 
                                                               value="{{ $service['title'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mô tả</label>
                                                        <input type="text" class="form-control" 
                                                               name="quick_services[{{ $index }}][description]" 
                                                               value="{{ $service['description'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Liên kết</label>
                                                        <input type="text" class="form-control" 
                                                               name="quick_services[{{ $index }}][url]" 
                                                               value="{{ $service['url'] }}" 
                                                               placeholder="# hoặc URL" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger remove-service">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-success" id="add-service">
                                    <i class="fas fa-plus"></i> Thêm dịch vụ
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật dịch vụ nhanh
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Management Tab -->
                    <div class="tab-pane fade" id="categories" role="tabpanel">
                        <!-- Visibility Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fas fa-tags text-primary"></i>
                                    Hiển thị danh mục bài viết
                                </h5>
                                <small class="text-muted">Bật/tắt hiển thị danh mục bài viết trên trang chủ</small>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input visibility-toggle" 
                                       role="switch" id="toggle_categories" 
                                       data-section="categories"
                                       {{ $settings->show_categories ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle_categories"></label>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Hướng dẫn:</strong> Cấu hình các danh mục bài viết hiển thị ở trang chủ. Có thể đặt thứ tự, số lượng bài viết và ưu tiên hiển thị bài nổi bật.
                        </div>

                        <form action="{{ route('admin.home.category-config.update') }}" method="POST">
                            @csrf
                            <div id="categories-container">
                                @if($settings->category_display_config)
                                    @foreach($settings->category_display_config as $index => $category)
                                        <div class="category-item card mb-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-tag"></i> Danh mục {{ $index + 1 }}
                                                </h6>
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-category">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Chọn danh mục</label>
                                                            <select class="form-control category-select" 
                                                                    name="category_display_config[{{ $index }}][category_id]" 
                                                                    data-index="{{ $index }}" required>
                                                                <option value="">-- Chọn danh mục --</option>
                                                                @foreach($categories as $cat)
                                                                    <option value="{{ $cat->id }}" 
                                                                            data-name="{{ $cat->name }}"
                                                                            data-slug="{{ $cat->slug }}"
                                                                            {{ ($category['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                                                                        {{ $cat->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <small class="text-muted">Chọn từ danh mục có sẵn</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Tên hiển thị</label>
                                                            <input type="text" class="form-control category-name-input" 
                                                                   name="category_display_config[{{ $index }}][category_name]" 
                                                                   value="{{ $category['category_name'] ?? '' }}" 
                                                                   placeholder="Tên hiển thị trên trang chủ" required>
                                                            <small class="text-muted">Có thể chỉnh sửa tên hiển thị</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Thứ tự hiển thị</label>
                                                            <input type="number" class="form-control" 
                                                                   name="category_display_config[{{ $index }}][display_order]" 
                                                                   value="{{ $category['display_order'] ?? 1 }}" 
                                                                   min="1" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Số bài hiển thị</label>
                                                            <input type="number" class="form-control" 
                                                                   name="category_display_config[{{ $index }}][posts_limit]" 
                                                                   value="{{ $category['posts_limit'] ?? 6 }}" 
                                                                   min="1" max="50" required>
                                                            <small class="text-muted">Tối đa 50 bài</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Hiển thị</label>
                                                            <div class="form-check form-switch mt-2">
                                                                <input type="hidden" name="category_display_config[{{ $index }}][is_visible]" value="0">
                                                                <input type="checkbox" class="form-check-input" 
                                                                       name="category_display_config[{{ $index }}][is_visible]" 
                                                                       value="1" {{ ($category['is_visible'] ?? true) ? 'checked' : '' }}>
                                                                <label class="form-check-label">Hiển thị trang chủ</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Ưu tiên nổi bật</label>
                                                            <div class="form-check form-switch mt-2">
                                                                <input type="hidden" name="category_display_config[{{ $index }}][show_featured_only]" value="0">
                                                                <input type="checkbox" class="form-check-input" 
                                                                       name="category_display_config[{{ $index }}][show_featured_only]" 
                                                                       value="1" {{ ($category['show_featured_only'] ?? false) ? 'checked' : '' }}>
                                                                <label class="form-check-label">Chỉ bài nổi bật</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">&nbsp;</label>
                                                            <div class="mt-2">
                                                                <button type="button" class="btn btn-outline-danger btn-sm remove-category w-100">
                                                                    <i class="fas fa-trash"></i> Xóa
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="category_display_config[{{ $index }}][category_slug]" 
                                                       value="{{ $category['category_slug'] ?? '' }}" class="category-slug-input">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-success" id="add-category">
                                    <i class="fas fa-plus"></i> Thêm danh mục mới
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật cấu hình danh mục
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Website Config Tab -->
                    <div class="tab-pane fade" id="website-config" role="tabpanel">
                        <form action="{{ route('admin.home.website-config.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Header & Logo Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-image"></i> Hình ảnh Website</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="header_image">Ảnh Header</label>
                                                <input type="file" class="form-control-file @error('header_image') is-invalid @enderror" 
                                                       id="header_image" name="header_image" accept="image/*">
                                                <small class="form-text text-muted">Hiện tại: {{ $settings->header_image ?? 'bg_header.jpg' }}</small>
                                                @error('header_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                                       id="logo" name="logo" accept="image/*">
                                                <small class="form-text text-muted">Hiện tại: {{ $settings->logo ?? 'logo.png' }}</small>
                                                @error('logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-phone"></i> Thông tin liên hệ</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_phone" class="required">Số điện thoại</label>
                                                <input type="text" class="form-control @error('contact_info.phone') is-invalid @enderror" 
                                                       id="contact_phone" name="contact_info[phone]" 
                                                       value="{{ old('contact_info.phone', $settings->contact_info['phone'] ?? '') }}" required>
                                                @error('contact_info.phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_email" class="required">Email</label>
                                                <input type="email" class="form-control @error('contact_info.email') is-invalid @enderror" 
                                                       id="contact_email" name="contact_info[email]" 
                                                       value="{{ old('contact_info.email', $settings->contact_info['email'] ?? '') }}" required>
                                                @error('contact_info.email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_address" class="required">Địa chỉ</label>
                                                <textarea class="form-control @error('contact_info.address') is-invalid @enderror" 
                                                          id="contact_address" name="contact_info[address]" rows="2" required>{{ old('contact_info.address', $settings->contact_info['address'] ?? '') }}</textarea>
                                                @error('contact_info.address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- School Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-school"></i> Thông tin trường</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="school_name" class="required">Tên trường</label>
                                                <input type="text" class="form-control @error('school_info.name') is-invalid @enderror" 
                                                       id="school_name" name="school_info[name]" 
                                                       value="{{ old('school_info.name', $settings->school_info['name'] ?? '') }}" required>
                                                @error('school_info.name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parent_organization" class="required">Đơn vị chủ quản</label>
                                                <input type="text" class="form-control @error('school_info.parent_organization') is-invalid @enderror" 
                                                       id="parent_organization" name="school_info[parent_organization]" 
                                                       value="{{ old('school_info.parent_organization', $settings->school_info['parent_organization'] ?? '') }}" required>
                                                @error('school_info.parent_organization')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="short_description" class="required">Mô tả ngắn</label>
                                                <input type="text" class="form-control @error('school_info.short_description') is-invalid @enderror" 
                                                       id="short_description" name="school_info[short_description]" 
                                                       value="{{ old('school_info.short_description', $settings->school_info['short_description'] ?? '') }}" required>
                                                @error('school_info.short_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Links Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-share-alt"></i> Liên kết mạng xã hội</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="facebook_url">Facebook</label>
                                                <input type="url" class="form-control @error('social_links.facebook') is-invalid @enderror" 
                                                       id="facebook_url" name="social_links[facebook]" 
                                                       value="{{ old('social_links.facebook', $settings->social_links['facebook'] ?? '') }}" 
                                                       placeholder="https://facebook.com/...">
                                                @error('social_links.facebook')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="youtube_url">YouTube</label>
                                                <input type="url" class="form-control @error('social_links.youtube') is-invalid @enderror" 
                                                       id="youtube_url" name="social_links[youtube]" 
                                                       value="{{ old('social_links.youtube', $settings->social_links['youtube'] ?? '') }}" 
                                                       placeholder="https://youtube.com/...">
                                                @error('social_links.youtube')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="website_url">Website khác</label>
                                                <input type="url" class="form-control @error('social_links.website') is-invalid @enderror" 
                                                       id="website_url" name="social_links[website]" 
                                                       value="{{ old('social_links.website', $settings->social_links['website'] ?? '') }}" 
                                                       placeholder="https://...">
                                                @error('social_links.website')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Cập nhật cấu hình website
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.required:after {
    content: " *";
    color: red;
}

.current-banner-preview img {
    max-height: 200px;
    width: 100%;
    object-fit: cover;
}

.nav-tabs .nav-link {
    border-radius: 0.375rem 0.375rem 0 0;
}

.nav-tabs .nav-link.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.tab-content {
    min-height: 400px;
}

.quick-link-item, .notification-item, .activity-item, .event-item, .service-item {
    transition: all 0.3s ease;
}

.quick-link-item:hover, .notification-item:hover, .activity-item:hover, .event-item:hover, .service-item:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Bootstrap 5 Switch Styles */
.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.form-check-input:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-check-input[type=checkbox] {
    border-radius: 0.375rem;
}

.form-switch .form-check-input {
    width: 2em;
    margin-left: -2.5em;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%2833, 37, 41, 0.25%29'/%3e%3c/svg%3e");
    background-position: left center;
    background-repeat: no-repeat;
    background-size: contain;
    border-radius: 2em;
}

.form-switch .form-check-input:checked {
    background-position: right center;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
}

/* Tab disabled state */
.nav-tabs .nav-link.opacity-50 {
    opacity: 0.5;
}

.nav-tabs .nav-link .text-muted {
    color: #6c757d !important;
}

/* Visibility toggle section */
.bg-light {
    background-color: #f8f9fa !important;
}

.border {
    border: 1px solid #dee2e6 !important;
}

.rounded {
    border-radius: 0.375rem !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let quickLinkIndex = {{ $settings->quick_links ? count($settings->quick_links) : 0 }};
    let notificationIndex = {{ $settings->notifications ? count($settings->notifications) : 0 }};
    let activityIndex = {{ $settings->featured_activities ? count($settings->featured_activities) : 0 }};
    let eventIndex = {{ $settings->upcoming_events ? count($settings->upcoming_events) : 0 }};
    let serviceIndex = {{ $settings->quick_services ? count($settings->quick_services) : 0 }};

    // Add Quick Link
    $('#add-quick-link').click(function() {
        const html = `
            <div class="quick-link-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" class="form-control" name="quick_links[${quickLinkIndex}][title]" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Liên kết</label>
                            <input type="text" class="form-control" name="quick_links[${quickLinkIndex}][url]" placeholder="# hoặc tên route hoặc URL đầy đủ" required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-quick-link">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#quick-links-container').append(html);
        quickLinkIndex++;
    });

    // Add Notification
    $('#add-notification').click(function() {
        const html = `
            <div class="notification-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Tiêu đề thông báo</label>
                            <input type="text" class="form-control" name="notifications[${notificationIndex}][title]" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ngày</label>
                            <input type="text" class="form-control" name="notifications[${notificationIndex}][date]" placeholder="1 tháng 1, 2026" required>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-notification">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#notifications-container').append(html);
        notificationIndex++;
    });

    // Add Activity
    $('#add-activity').click(function() {
        const html = `
            <div class="activity-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" class="form-control" name="featured_activities[${activityIndex}][title]" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="2" name="featured_activities[${activityIndex}][description]" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>URL Video</label>
                            <input type="url" class="form-control" name="featured_activities[${activityIndex}][video_url]" placeholder="https://www.youtube.com/embed/..." required>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-activity">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#activities-container').append(html);
        activityIndex++;
    });

    // Add Event
    $('#add-event').click(function() {
        const html = `
            <div class="event-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Tên sự kiện</label>
                            <input type="text" class="form-control" name="upcoming_events[${eventIndex}][title]" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Thời gian</label>
                            <input type="text" class="form-control" name="upcoming_events[${eventIndex}][date]" placeholder="15 tháng 4, 2026" required>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-event">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#events-container').append(html);
        eventIndex++;
    });

    // Add Service
    $('#add-service').click(function() {
        const html = `
            <div class="service-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tên dịch vụ</label>
                            <input type="text" class="form-control" name="quick_services[${serviceIndex}][title]" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="quick_services[${serviceIndex}][description]" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Liên kết</label>
                            <input type="text" class="form-control" name="quick_services[${serviceIndex}][url]" placeholder="# hoặc URL" required>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-service">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#services-container').append(html);
        serviceIndex++;
    });

    // Remove handlers (using event delegation)
    $(document).on('click', '.remove-quick-link', function() {
        $(this).closest('.quick-link-item').remove();
    });

    $(document).on('click', '.remove-notification', function() {
        $(this).closest('.notification-item').remove();
    });

    $(document).on('click', '.remove-activity', function() {
        $(this).closest('.activity-item').remove();
    });

    $(document).on('click', '.remove-event', function() {
        $(this).closest('.event-item').remove();
    });

    $(document).on('click', '.remove-service', function() {
        $(this).closest('.service-item').remove();
    });

    // Image preview
    $('#featured_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.current-banner-preview img').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Xử lý Toggle Visibility
    $('.visibility-toggle').change(function() {
        const section = $(this).data('section');
        const visible = $(this).is(':checked');
        const $toggle = $(this);
        
        console.log('Toggle changed:', section, 'visible:', visible, 'type:', typeof visible); // Debug log
        
        // Disable toggle while processing
        $toggle.prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.home.toggle-visibility") }}',
            method: 'POST',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {
                _token: '{{ csrf_token() }}',
                section: section,
                visible: visible ? 1 : 0  // Convert to integer for Laravel
            },
            success: function(response) {
                console.log('AJAX Success:', response); // Debug log
                if(response.success) {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    } else {
                    }
                    
                    // Update tab indicator
                    updateTabIndicator(section, visible);
                } else {
                    // Revert toggle state
                    $toggle.prop('checked', !visible);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Có lỗi xảy ra');
                    } else {
                        alert('❌ ' + (response.message || 'Có lỗi xảy ra'));
                    }
                }
            },
            error: function(xhr) {
                console.log('AJAX Error:', xhr); // Debug log
                console.log('Response Text:', xhr.responseText); // Debug response
                console.log('Status:', xhr.status); // Debug status
                
                // Try to parse error response
                let errorMessage = 'Có lỗi xảy ra khi cập nhật trạng thái hiển thị';
                try {
                    const errorData = JSON.parse(xhr.responseText);
                    if (errorData.message) {
                        errorMessage = errorData.message;
                    } else if (errorData.errors) {
                        const errors = Object.values(errorData.errors).flat();
                        errorMessage = errors.join(', ');
                    }
                } catch (e) {
                    console.log('Could not parse error response');
                }
                
                // Revert toggle state
                $toggle.prop('checked', !visible);
                if (typeof toastr !== 'undefined') {
                    toastr.error(errorMessage);
                } else {
                    alert('❌ ' + errorMessage);
                }
            },
            complete: function() {
                console.log('AJAX Complete'); // Debug log
                // Re-enable toggle
                $toggle.prop('disabled', false);
            }
        });
    });
    
    function updateTabIndicator(section, visible) {
        const tabMap = {
            'featured_banner': '#featured-tab',
            'quick_links': '#quick-links-tab',
            'notifications': '#notifications-tab',
            'activities': '#activities-tab',
            'events': '#events-tab',
            'services': '#services-tab',
            'categories': '#categories-tab'
        };
        
        const $tab = $(tabMap[section]);
        if (visible) {
            $tab.removeClass('opacity-50').find('i').removeClass('text-muted');
        } else {
            $tab.addClass('opacity-50').find('i').addClass('text-muted');
        }
    }

    // Category Management
    let categoryIndex = {{ $settings->category_display_config ? count($settings->category_display_config) : 0 }};
    
    $('#add-category').click(function() {
        const categoriesOptions = `
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" data-name="{{ $cat->name }}" data-slug="{{ $cat->slug }}">{{ $cat->name }}</option>
            @endforeach
        `;
        
        const html = `
            <div class="category-item card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-tag"></i> Danh mục mới
                    </h6>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-category">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label">Chọn danh mục</label>
                                <select class="form-control category-select" 
                                        name="category_display_config[${categoryIndex}][category_id]" 
                                        data-index="${categoryIndex}" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    ${categoriesOptions}
                                </select>
                                <small class="text-muted">Chọn từ danh mục có sẵn</small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label class="form-label">Tên hiển thị</label>
                                <input type="text" class="form-control category-name-input" 
                                       name="category_display_config[${categoryIndex}][category_name]" 
                                       placeholder="Tên hiển thị trên trang chủ" required>
                                <small class="text-muted">Có thể chỉnh sửa tên hiển thị</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" 
                                       name="category_display_config[${categoryIndex}][display_order]" 
                                       value="${categoryIndex + 1}" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label">Số bài hiển thị</label>
                                <input type="number" class="form-control" 
                                       name="category_display_config[${categoryIndex}][posts_limit]" 
                                       value="6" min="1" max="50" required>
                                <small class="text-muted">Tối đa 50 bài</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Hiển thị</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="hidden" name="category_display_config[${categoryIndex}][is_visible]" value="0">
                                    <input type="checkbox" class="form-check-input" 
                                           name="category_display_config[${categoryIndex}][is_visible]" 
                                           value="1" checked>
                                    <label class="form-check-label">Hiển thị trang chủ</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Ưu tiên nổi bật</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="hidden" name="category_display_config[${categoryIndex}][show_featured_only]" value="0">
                                    <input type="checkbox" class="form-check-input" 
                                           name="category_display_config[${categoryIndex}][show_featured_only]" 
                                           value="1">
                                    <label class="form-check-label">Chỉ bài nổi bật</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-category w-100">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category_display_config[${categoryIndex}][category_slug]" value="" class="category-slug-input">
                </div>
            </div>
        `;
        $('#categories-container').append(html);
        categoryIndex++;
    });

    // Remove category
    $(document).on('click', '.remove-category', function() {
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
            $(this).closest('.category-item').remove();
        }
    });

    // Auto fill category name and slug when selecting category
    $(document).on('change', '.category-select', function() {
        const $selected = $(this).find('option:selected');
        const $container = $(this).closest('.card-body');
        
        if ($selected.val()) {
            // Fill name từ category được chọn
            const categoryName = $selected.data('name');
            const categorySlug = $selected.data('slug');
            
            $container.find('.category-name-input').val(categoryName);
            $container.find('.category-slug-input').val(categorySlug);
        } else {
            // Clear fields if no selection
            $container.find('.category-name-input').val('');
            $container.find('.category-slug-input').val('');
        }
    });
});
</script>
@endpush