<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'use_book_now' => 'boolean',
    ];

    public function getBookNowUrl()
    {
        return $this->book_now_url ? json_decode($this->book_now_url) : [];
    }
}
