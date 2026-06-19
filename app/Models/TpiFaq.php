<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiFaq extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getActiveList()
    {
        return static::query()->where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
    }
}
