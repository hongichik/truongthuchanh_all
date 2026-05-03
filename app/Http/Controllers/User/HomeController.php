<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Helpers\CategoryDisplayHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        $homeSettings = HomeSetting::current();
        $categoryData = CategoryDisplayHelper::getHomepageCategories();
        
        return view('user.home.index', compact('homeSettings', 'categoryData'));
    }
    public function contact()
    {
        return view('user.home.contact');
    }
}
