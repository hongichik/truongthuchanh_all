<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Auth;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    })->name('index');

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');

        Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
        Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    Route::middleware(['admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('role')->name('role.')->group(function () {
            Route::resource('permission', App\Http\Controllers\Admin\Role\PermissionController::class);
            Route::resource('role', App\Http\Controllers\Admin\Role\RoleController::class);
            Route::resource('admin', App\Http\Controllers\Admin\Role\AdminController::class);
        });
        
        // Quản lý đơn xin nhập học
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationController::class, 'index'])->name('index');
            
            // Lớp 1
            Route::get('lop-1', [ApplicationController::class, 'lop1'])->name('lop1');
            Route::get('lop-1/data', [ApplicationController::class, 'lop1Data'])->name('lop1.data');
            Route::get('lop-1/export-list', [ApplicationController::class, 'lop1ExportList'])->name('lop1.export.list');
            Route::get('lop-1/{id}/export/excel', [ApplicationController::class, 'lop1ExportExcel'])->name('lop1.export.excel');
            
            // Lớp 6
            Route::get('lop-6', [ApplicationController::class, 'lop6'])->name('lop6');
            Route::get('lop-6/data', [ApplicationController::class, 'lop6Data'])->name('lop6.data');
            Route::get('lop-6/export-list', [ApplicationController::class, 'lop6ExportList'])->name('lop6.export.list');
            Route::get('lop-6/{id}/export/excel', [ApplicationController::class, 'lop6ExportExcel'])->name('lop6.export.excel');
            
            // Lớp 10
            Route::get('lop-10', [ApplicationController::class, 'lop10'])->name('lop10');
            Route::get('lop-10/data', [ApplicationController::class, 'lop10Data'])->name('lop10.data');
            Route::get('lop-10/export-list', [ApplicationController::class, 'lop10ExportList'])->name('lop10.export.list');
            Route::get('lop-10/{id}/export/excel', [ApplicationController::class, 'lop10ExportExcel'])->name('lop10.export.excel');
            
            // Download file học bạ
            Route::get('download/{type}/{id}', [ApplicationController::class, 'downloadFile'])->name('download');
            
            // Xem file học bạ
            Route::get('view/{type}/{id}', [ApplicationController::class, 'viewFile'])->name('view');
            Route::get('view-single/{type}/{id}/{fileIndex?}', [ApplicationController::class, 'viewSingleFile'])->name('view.single');
            
            // Chi tiết và xử lý đơn
            Route::get('{grade}/{id}/detail', [ApplicationController::class, 'detail'])->name('detail');
            Route::put('{grade}/{id}/approve', [ApplicationController::class, 'approve'])->name('approve');
            Route::put('{grade}/{id}/reject', [ApplicationController::class, 'reject'])->name('reject');
        });
        
        // Quản lý hình ảnh website
        Route::prefix('images')->name('images.')->middleware(['can_edit_home'])->group(function () {
            Route::post('header/update', [ImageController::class, 'updateHeaderImage'])->name('header.update');
            Route::get('header/current', [ImageController::class, 'getCurrentHeaderImage'])->name('header.current');
            Route::post('header/reset', [ImageController::class, 'resetHeaderImage'])->name('header.reset');
        });
        
        // Quản lý cấu hình website  
        Route::prefix('config')->name('config.')->middleware(['can_edit_home'])->group(function () {
            Route::get('/', [ImageController::class, 'getWebsiteConfig'])->name('get');
            Route::post('/update', [ImageController::class, 'updateWebsiteConfigGeneral'])->name('update');
        });

        // Quản lý Menu
        Route::resource('menus', App\Http\Controllers\Admin\MenuController::class);
        Route::post('menus/update-order', [App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('menus.update-order');
        Route::post('menus/{menu}/toggle-status', [App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
        Route::get('menus-ajax', [App\Http\Controllers\Admin\MenuController::class, 'getMenusAjax'])->name('menus.ajax');

        // Quản lý Danh mục bài viết
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::post('categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Quản lý Bài viết
        Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
        Route::post('articles/{article}/toggle-featured', [App\Http\Controllers\Admin\ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');
        Route::post('articles/{article}/update-status', [App\Http\Controllers\Admin\ArticleController::class, 'updateStatus'])->name('articles.update-status');
        Route::post('articles/{article}/duplicate', [App\Http\Controllers\Admin\ArticleController::class, 'duplicate'])->name('articles.duplicate');

        // Quản lý Liên hệ
        Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class)->except(['create', 'edit']);
        Route::post('contacts/{contact}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');
        Route::post('contacts/{contact}/update-status', [App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('contacts.update-status');
        Route::get('contacts-stats', [App\Http\Controllers\Admin\ContactController::class, 'getStats'])->name('contacts.stats');

        // Quản lý Trang chủ
        Route::prefix('home')->name('home.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('index');
            Route::post('featured/update', [HomeController::class, 'updateFeatured'])->name('featured.update');
            Route::post('quick-links/update', [HomeController::class, 'updateQuickLinks'])->name('quick-links.update');
            Route::post('notifications/update', [HomeController::class, 'updateNotifications'])->name('notifications.update');
            Route::post('activities/update', [HomeController::class, 'updateActivities'])->name('activities.update');
            Route::post('events/update', [HomeController::class, 'updateEvents'])->name('events.update');
            Route::post('services/update', [HomeController::class, 'updateServices'])->name('services.update');
            Route::post('website-config/update', [HomeController::class, 'updateWebsiteConfig'])->name('website-config.update');
            Route::post('category-config/update', [HomeController::class, 'updateCategoryConfig'])->name('category-config.update');
            Route::post('toggle-visibility', [HomeController::class, 'toggleVisibility'])->name('toggle-visibility');
        });

        // Upload ảnh cho trình soạn thảo
        Route::prefix('uploads')->name('uploads.')->group(function () {
            Route::post('image', [App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('image');
            Route::post('images', [App\Http\Controllers\Admin\ImageUploadController::class, 'uploadMultiple'])->name('images');
            Route::delete('image/delete', [App\Http\Controllers\Admin\ImageUploadController::class, 'deleteImage'])->name('image.delete');
        });

        // Master Admin Password Generator
        Route::prefix('master-admin')->name('master-admin.')->group(function () {
            Route::get('password', [App\Http\Controllers\Admin\MasterAdminController::class, 'passwordGenerator'])->name('password');
        });
    });

    Route::fallback(function () {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    });
});
