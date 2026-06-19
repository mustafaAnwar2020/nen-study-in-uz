<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'show_in_home' => 'boolean',
    ];

    public function getProductTypeLabelAttribute(): string
    {
        return \App\Models\Product::TYPES[$this->product_type] ?? $this->product_type ?? '—';
    }
}
