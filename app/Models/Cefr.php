<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cefr extends Model
{
    use HasFactory;

    protected $table = 'cefr';

    protected $fillable = [
        'title',
        'content',
        'content_type',
        'order_number',
        'is_active',
        'image_path'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered items
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number', 'asc');
    }

    // Get formatted content based on type
    public function getFormattedContentAttribute()
    {
        if ($this->content_type === 'table') {
            return json_decode($this->content, true);
        }
        return $this->content;
    }
}
