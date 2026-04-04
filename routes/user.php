<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NhapHocController;

// Trang chủ và các trang thông tin
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');
Route::get('/tin-tuc', [HomeController::class, 'news'])->name('news');
Route::get('/lien-he', [HomeController::class, 'contact'])->name('contact');

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