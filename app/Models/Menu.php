<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
        'icon',
        'description',
        'parent_id',
        'sort_order',
        'target',
        'status',
        'position'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    /**
     * Quan hệ với menu cha
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Quan hệ với menu con
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Lấy tất cả menu con (đệ quy)
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Kiểm tra xem có phải menu gốc không
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Kiểm tra xem có menu con không
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Lấy đường dẫn đầy đủ của menu
     */
    public function getFullPath(): array
    {
        $path = [$this];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent);
            $parent = $parent->parent;
        }
        
        return $path;
    }

    /**
     * Scope để lấy menu theo vị trí
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope để lấy menu active
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope để lấy menu gốc
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Lấy menu theo thứ tự hiển thị
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
