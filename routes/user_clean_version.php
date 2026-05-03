<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\ContactController;

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

// Registration routes
Route::get('/dang-ky-lop-1', function() {
    return view('user.registration.lop-1');
})->name('dang-ky.lop1');

Route::get('/dang-ky-lop-3', function() {
    return view('user.registration.lop-3');  
})->name('dang-ky.lop3');

Route::get('/dang-ky-lop-6', function() {
    return view('user.registration.lop-6');
})->name('dang-ky.lop6');

Route::get('/dang-ky-lop-10', function() {
    return view('user.registration.lop-10');
})->name('dang-ky.lop10');