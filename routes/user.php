<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NhapHocController;
use App\Http\Controllers\User\ArticleController;

// Trang chủ và các trang thông tin (đặt trước để tránh conflict)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lien-he', [HomeController::class, 'contact'])->name('contact');

// Routes for articles and categories
Route::get('/bai-viet/{category_slug}', [ArticleController::class, 'categoryIndex'])->name('category.articles');

// Đăng ký nhập học
Route::prefix('dang-ky')->name('dang-ky.')->group(function () {
    // Lớp 1
    Route::get('/lop-1', [NhapHocController::class, 'dangKyLop1'])->name('lop1');
    Route::post('/lop-1', [NhapHocController::class, 'storeLop1'])->name('lop1.store');
    
    // Lớp 6
    Route::get('/lop-6', [NhapHocController::class, 'dangKyLop6'])->name('lop6');
    Route::post('/lop-6', [NhapHocController::class, 'storeLop6'])->name('lop6.store');
    
    // Lớp 10
    Route::get('/lop-10', [NhapHocController::class, 'dangKyLop10'])->name('lop10');
    Route::post('/lop-10', [NhapHocController::class, 'storeLop10'])->name('lop10.store');
});

// Route for articles (đặt cuối để tránh conflict với static routes)  
Route::get('/bai-viet/{category_slug}/{article_slug}', [ArticleController::class, 'show'])->name('article.show');