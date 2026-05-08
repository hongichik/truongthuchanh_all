<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $settings = HomeSetting::current();
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('admin.home.index', compact('settings', 'categories'));
    }

    public function updateFeatured(Request $request)
    {
        $request->validate([
            'featured_title' => 'required|string|max:255',
            'featured_subtitle' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $settings = HomeSetting::current();
        
        $settings->featured_title = $request->featured_title;
        $settings->featured_subtitle = $request->featured_subtitle;
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists (except default)
            if ($settings->featured_image && $settings->featured_image != 'assets/image/banner_home.jpg') {
                Storage::disk('public')->delete($settings->featured_image);
            }
            
            $imagePath = $request->file('featured_image')->store('home-images', 'public');
            $settings->featured_image = $imagePath;
        }
        
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật banner thành công!');
    }

    public function updateQuickLinks(Request $request)
    {
        $request->validate([
            'quick_links' => 'required|array',
            'quick_links.*.title' => 'required|string|max:100',
            'quick_links.*.url' => 'required|string|max:255'
        ]);

        $settings = HomeSetting::current();
        $settings->quick_links = $request->quick_links;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật liên kết nhanh thành công!');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'notifications' => 'required|array',
            'notifications.*.title' => 'required|string|max:255',
            'notifications.*.date' => 'required|string|max:100',
            'notifications.*.url' => ['nullable', 'string', 'max:500', 'regex:/^(https?:\/\/|\/|#).*/i']
        ]);

        $settings = HomeSetting::current();
        $settings->notifications = $request->notifications;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật thông báo thành công!');
    }

    public function updateActivities(Request $request)
    {
        $request->validate([
            'featured_activities' => 'required|array',
            'featured_activities.*.title' => 'required|string|max:255',
            'featured_activities.*.description' => 'required|string|max:500',
            'featured_activities.*.video_url' => 'required|url|max:500'
        ]);

        $settings = HomeSetting::current();
        $settings->featured_activities = $request->featured_activities;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật hoạt động nổi bật thành công!');
    }

    public function updateEvents(Request $request)
    {
        $request->validate([
            'upcoming_events' => 'required|array', 
            'upcoming_events.*.title' => 'required|string|max:255',
            'upcoming_events.*.date' => 'required|string|max:100',
            'upcoming_events.*.url' => ['nullable', 'string', 'max:500', 'regex:/^(https?:\/\/|\/|#).*/i']
        ]);

        $settings = HomeSetting::current();
        $settings->upcoming_events = $request->upcoming_events;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật sự kiện sắp tới thành công!');
    }

    public function updateServices(Request $request)
    {
        $request->validate([
            'quick_services' => 'required|array',
            'quick_services.*.title' => 'required|string|max:255',
            'quick_services.*.description' => 'required|string|max:255',
            'quick_services.*.url' => 'required|string|max:500'
        ]);

        $settings = HomeSetting::current();
        $settings->quick_services = $request->quick_services;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật dịch vụ nhanh thành công!');
    }
    public function updateWebsiteConfig(Request $request)
    {
        $request->validate([
            'header_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'logo' => 'sometimes|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'contact_info.phone' => 'required|string|max:20',
            'contact_info.email' => 'required|email|max:255',
            'contact_info.address' => 'required|string|max:500',
            'school_info.name' => 'required|string|max:255',
            'school_info.parent_organization' => 'required|string|max:255',
            'school_info.short_description' => 'required|string|max:255',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.youtube' => 'nullable|url|max:255',
            'social_links.website' => 'nullable|url|max:255'
        ]);

        $setting = HomeSetting::current();

        // Xử lý upload header image
        if ($request->hasFile('header_image')) {
            $image = $request->file('header_image');
            $imageName = 'header_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/image'), $imageName);
            $setting->header_image = $imageName;
        }

        // Xử lý upload logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/image'), $logoName);
            $setting->logo = $logoName;
        }

        // Cập nhật thông tin liên hệ
        $setting->contact_info = [
            'phone' => $request->input('contact_info.phone'),
            'email' => $request->input('contact_info.email'),
            'address' => $request->input('contact_info.address')
        ];

        // Cập nhật thông tin trường
        $setting->school_info = [
            'name' => $request->input('school_info.name'),
            'parent_organization' => $request->input('school_info.parent_organization'),
            'short_description' => $request->input('school_info.short_description')
        ];

        // Cập nhật liên kết mạng xã hội
        $setting->social_links = [
            'facebook' => $request->input('social_links.facebook'),
            'youtube' => $request->input('social_links.youtube'),
            'website' => $request->input('social_links.website')
        ];

        $setting->save();

        return back()->with('success', 'Đã cập nhật cấu hình website thành công!');
    }

    public function toggleVisibility(Request $request)
    {
        $request->validate([
            'section' => 'required|string|in:featured_banner,quick_links,notifications,activities,events,services,categories',
            'visible' => 'required'  // Accept any value, we'll convert to boolean
        ]);

        $setting = HomeSetting::current();
        $section = $request->section;
        
        // Convert visible to boolean - handle both string and boolean inputs
        $visible = filter_var($request->visible, FILTER_VALIDATE_BOOLEAN);

        // Map tên section sang tên field tương ứng
        $fieldMap = [
            'featured_banner' => 'show_featured_banner',
            'quick_links' => 'show_quick_links',
            'notifications' => 'show_notifications',
            'activities' => 'show_activities',
            'events' => 'show_events',
            'services' => 'show_services',
            'categories' => 'show_categories'
        ];

        $field = $fieldMap[$section];
        $setting->$field = $visible;
        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật trạng thái hiển thị thành công!',
            'visible' => $visible,
            'section' => $section,
            'field' => $field
        ]);
    }

    public function updateCategoryConfig(Request $request)
    {
        $request->validate([
            'category_display_config' => 'required|array',
            'category_display_config.*.category_id' => 'nullable|exists:categories,id',
            'category_display_config.*.category_name' => 'required|string|max:255',
            'category_display_config.*.display_order' => 'required|integer|min:1',
            'category_display_config.*.is_visible' => 'boolean',
            'category_display_config.*.posts_limit' => 'required|integer|min:1|max:50',
            'category_display_config.*.show_featured_only' => 'boolean'
        ]);

        $settings = HomeSetting::current();
        
        // Xử lý checkbox values và lấy slug từ category
        $categoryConfig = [];
        foreach ($request->category_display_config as $index => $category) {
            // Lấy slug từ category nếu có category_id
            $categorySlug = null;
            if (!empty($category['category_id'])) {
                $cat = \App\Models\Category::find($category['category_id']);
                $categorySlug = $cat ? $cat->slug : null;
            } else {
                // Nếu không có category_id thì tạo slug từ tên
                $categorySlug = \Str::slug($category['category_name']);
            }
            
            $categoryConfig[] = [
                'category_id' => $category['category_id'] ?? null,
                'category_name' => $category['category_name'],
                'category_slug' => $categorySlug,
                'display_order' => (int) $category['display_order'],
                'is_visible' => isset($category['is_visible']) && $category['is_visible'] == '1',
                'posts_limit' => (int) $category['posts_limit'],
                'show_featured_only' => isset($category['show_featured_only']) && $category['show_featured_only'] == '1'
            ];
        }
        
        $settings->category_display_config = $categoryConfig;
        $settings->save();

        return redirect()->back()->with('success', 'Cập nhật cấu hình danh mục thành công!');
    }}