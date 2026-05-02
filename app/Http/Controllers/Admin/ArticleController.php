<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author'])
                       ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->paginate(20)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = 'assets/articles/' . $filename;
            $image->move(public_path('assets/articles'), $filename);
            $validated['featured_image'] = $path;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['created_by'] = auth()->guard('admin')->id();

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
                        ->with('success_alert', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['category', 'author', 'editor']);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($article->id)
            ],
            'description' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image && file_exists(public_path($article->featured_image))) {
                unlink(public_path($article->featured_image));
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = 'assets/articles/' . $filename;
            $image->move(public_path('assets/articles'), $filename);
            $validated['featured_image'] = $path;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['updated_by'] = auth()->guard('admin')->id();

        if ($validated['status'] === 'published' && !$article->published_at && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
                        ->with('success_alert', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete featured image if exists
        if ($article->featured_image && file_exists(public_path($article->featured_image))) {
            unlink(public_path($article->featured_image));
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
                        ->with('success_alert', 'Bài viết đã được xóa thành công!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Article $article)
    {
        $article->is_featured = !$article->is_featured;
        $article->save();

        return response()->json([
            'success' => true,
            'is_featured' => $article->is_featured,
            'message' => 'Trạng thái nổi bật đã được cập nhật!'
        ]);
    }

    /**
     * Update status
     */
    public function updateStatus(Request $request, Article $article)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);

        if ($validated['status'] === 'published' && !$article->published_at) {
            $article->published_at = now();
        }

        $article->status = $validated['status'];
        $article->updated_by = auth()->guard('admin')->id();
        $article->save();

        return response()->json([
            'success' => true,
            'status' => $article->status,
            'message' => 'Trạng thái bài viết đã được cập nhật!'
        ]);
    }

    /**
     * Duplicate article
     */
    public function duplicate(Article $article)
    {
        $newArticle = $article->replicate();
        $newArticle->title = $article->title . ' (Copy)';
        $newArticle->slug = Str::slug($newArticle->title) . '-' . time();
        $newArticle->status = 'draft';
        $newArticle->is_featured = false;
        $newArticle->view_count = 0;
        $newArticle->published_at = null;
        $newArticle->created_by = auth()->guard('admin')->id();
        $newArticle->updated_by = null;
        $newArticle->save();

        return redirect()->route('admin.articles.edit', $newArticle)
                        ->with('success_alert', 'Bài viết đã được sao chép thành công!');
    }
}
