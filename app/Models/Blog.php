<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use ModelsCommonTrait;

    protected $fillable = [
        'title',
        'slug',
        'article',
        'image',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const STATUS_PUBLISHED = 'published';
    public const STATUS_DRAFT = 'draft';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_DRAFT => 'Draft',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => '<span class="badge badge-success">Published</span>',
            self::STATUS_DRAFT => '<span class="badge badge-secondary">Draft</span>',
            default => '<span class="badge badge-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getExcerpt(int $length = 150): string
    {
        return strlen($this->article) > $length
            ? substr($this->article, 0, $length) . '...'
            : $this->article;
    }
}
