<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiJoinPartnerSection extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent()
    {
        return static::query()->where('is_active', true)->first();
    }

    public function getItemsList(): array
    {
        if (empty($this->items) || !is_array($this->items)) {
            return static::getDefaultItems();
        }
        return $this->items;
    }

    public static function getDefaultItems(): array
    {
        return [
            ['icon' => 'bi-building', 'icon_class' => 'icon-primary', 'title' => 'Are You a Preparation Center?', 'description' => 'Join the initiative and become an official Preparation Center.', 'button_text' => 'Register as a Preparation Center', 'button_url' => 'http://nen-global.org/corapp'],
            ['icon' => 'bi-file-person', 'icon_class' => '', 'title' => 'Are You an English Trainer / Facilitator / Mentor?', 'description' => 'Become an approved Educational Trainer / Facilitator / Mentor and help learners succeed.', 'button_text' => 'Register as a Trainer / Facilitator / Mentor', 'button_url' => 'http://nen-global.org/tqsapp'],
        ];
    }
}
