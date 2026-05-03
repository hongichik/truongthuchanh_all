<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NhapHocController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\ContactController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Category and Article routes
Route::prefix('bai-viet')->name('articles.')->group(function () {
    Route::get('/{categorySlug}', [ArticleController::class, 'categoryIndex'])->name('category');
    Route::get('/{categorySlug}/{slug}', [ArticleController::class, 'show'])->name('show');
});

// Contact routes
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');