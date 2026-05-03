<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Hiển thị danh sách bài viết theo danh mục
     */
    public function categoryIndex($category_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();
        
        $articles = Article::where('category_id', $category->id)
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        $homeSettings = HomeSetting::current();
        
        return view('user.articles.category', compact('category', 'articles', 'homeSettings'));
    }
    
    /**
     * Hiển thị chi tiết bài viết
     */
    public function show($category_slug, $article_slug)
    {
        // Validate category exists
        $category = Category::where('slug', $category_slug)->firstOrFail();
        
        // Get article and ensure it belongs to the category
        $article = Article::where('slug', $article_slug)
                         ->where('category_id', $category->id)
                         ->where('status', 'published')
                         ->firstOrFail();
        
        // Tăng lượt xem
        $article->increment('view_count');
        
        // Lấy bài viết liên quan cùng danh mục
        $relatedArticles = Article::with('category')
                                 ->where('category_id', $article->category_id)
                                 ->where('id', '!=', $article->id)
                                 ->where('status', 'published')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(6)
                                 ->get();
        
        $homeSettings = HomeSetting::current();
        
        return view('user.articles.show', compact('article', 'relatedArticles', 'homeSettings'));
    }
}