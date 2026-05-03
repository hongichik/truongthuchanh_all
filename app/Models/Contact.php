<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_at',
        'replied_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Relationship with Admin who replied to this contact
     */
    public function repliedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'replied_by');
    }

    /**
     * Scope for pending contacts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for replied contacts 
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Chờ phản hồi';
            case 'replied':
                return 'Đã phản hồi';
            case 'archived':
                return 'Đã lưu trữ';
            default:
                return 'Chờ phản hồi';
        }
    }

    /**
     * Check if contact has been replied
     */
    public function isReplied()
    {
        return $this->status === 'replied';
    }
}
