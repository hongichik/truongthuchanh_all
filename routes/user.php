<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\NhapHocController;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Article routes
Route::prefix('bai-viet')->group(function () {
    Route::get('/{category_slug}', [ArticleController::class, 'categoryIndex'])->name('articles.category');
    Route::get('/{category_slug}/{article_slug}', [ArticleController::class, 'show'])->name('articles.show');
});

// Contact routes
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

// Registration routes with proper controller
Route::prefix('dang-ky')->name('dang-ky.')->group(function () {
    // Grade 1 registration
    Route::get('/lop-1', [NhapHocController::class, 'dangKyLop1'])->name('lop1');
    Route::post('/lop-1', [NhapHocController::class, 'storeLop1'])->name('lop1.store');
    
    // Grade 6 registration  
    Route::get('/lop-6', [NhapHocController::class, 'dangKyLop6'])->name('lop6');
    Route::post('/lop-6', [NhapHocController::class, 'storeLop6'])->name('lop6.store');
    
    // Grade 10 registration
    Route::get('/lop-10', [NhapHocController::class, 'dangKyLop10'])->name('lop10');
    Route::post('/lop-10', [NhapHocController::class, 'storeLop10'])->name('lop10.store');
});