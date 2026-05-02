<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'featured_image',
        'tags',
        'status',
        'is_featured',
        'view_count',
        'published_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method để tự động tạo slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if ($article->status === 'published' && !$article->published_at) {
                $article->published_at = now();
            }
        });
        
        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if ($article->isDirty('status') && $article->status === 'published' && !$article->published_at) {
                $article->published_at = now();
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    // Accessors & Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst(trim($value));
    }

    public function getExcerptAttribute($length = 150)
    {
        return Str::limit(strip_tags($this->description ?: $this->content), $length);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // Average 200 words per minute
        return max(1, $readingTime);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset($this->featured_image);
        }
        return asset('assets/image/default-article.jpg');
    }

    // Helper methods
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => '<span class="badge badge-secondary">Bản nháp</span>',
            'published' => '<span class="badge badge-success">Đã xuất bản</span>',
            'archived' => '<span class="badge badge-warning">Lưu trữ</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Không xác định</span>';
    }
}
