<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        $homeSettings = HomeSetting::current();
        
        return view('user.home.index', compact('homeSettings'));
    }
    
    /**
     * Hiển thị trang giới thiệu
     */
    public function about()
    {
        return view('user.home.about');
    }
    
    /**
     * Hiển thị tin tức
     */
    public function news()
    {
        return view('user.home.news');
    }
    
    /**
     * Hiển thị liên hệ
     */
    public function contact()
    {
        return view('user.home.contact');
    }
}
