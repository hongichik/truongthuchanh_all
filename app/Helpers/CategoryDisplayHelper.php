<?php

namespace App\Helpers;

use App\Models\HomeSetting;
use App\Models\Category;
use App\Models\Article;

class CategoryDisplayHelper
{
    /**
     * Lấy danh mục hiển thị trên trang chủ
     * 
     * @return array
     */
    public static function getHomepageCategories()
    {
        $settings = HomeSetting::current();
        
        if (!$settings->show_categories || !$settings->category_display_config) {
            return [];
        }
        
        $categories = collect($settings->category_display_config)
            ->where('is_visible', true)
            ->sortBy('display_order');
            
        $result = [];
        
        foreach ($categories as $categoryConfig) {
            // Tìm category thực tế trong database (ưu tiên category_id)
            $category = null;
            if ($categoryConfig['category_id']) {
                $category = Category::find($categoryConfig['category_id']);
            } else if ($categoryConfig['category_slug']) {
                // Fallback: tìm theo slug nếu không có category_id
                $category = Category::where('slug', $categoryConfig['category_slug'])->first();
            }
            
            // Lấy bài viết theo config
            $articlesQuery = Article::query()
                ->where('status', 'published')
                ->orderBy('created_at', 'desc');
                
            if ($category) {
                $articlesQuery->where('category_id', $category->id);
            } else {
                // Skip nếu không tìm thấy category
                continue;
            }
            
            // Nếu chỉ hiển thị bài nổi bật
            if ($categoryConfig['show_featured_only']) {
                $articlesQuery->where('is_featured', true);
            }
            
            $articles = $articlesQuery->limit($categoryConfig['posts_limit'])->get();
            
            $result[] = [
                'config' => $categoryConfig,
                'category' => $category,
                'articles' => $articles
            ];
        }
        
        return $result;
    }
    
    /**
     * Kiểm tra xem có hiển thị danh mục không
     * 
     * @return bool
     */
    public static function shouldShowCategories()
    {
        $settings = HomeSetting::current();
        return $settings->show_categories ?? true;
    }
}