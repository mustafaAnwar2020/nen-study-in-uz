<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiKeyBenefitsSection extends Model
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
            ['icon' => 'bi-gift-fill', 'icon_class' => 'icon-success', 'title' => '100% Free TOEFL Practice', 'description' => 'Complete practice experience with zero cost and no hidden fees'],
            ['icon' => 'bi-laptop', 'icon_class' => 'icon-primary', 'title' => 'Real Exam Simulation', 'description' => 'Experience authentic TOEFL test conditions and format'],
            ['icon' => 'bi-person-badge', 'icon_class' => 'icon-info', 'title' => 'Certified TOEFL Mentors', 'description' => 'Learn from experienced and qualified TOEFL instructors'],
            ['icon' => 'bi-clock-history', 'icon_class' => 'icon-purple', 'title' => 'Morning & Evening Schedules', 'description' => 'Flexible timing options that fit your daily routine'],
            ['icon' => 'bi-shield-check', 'icon_class' => 'icon-warning', 'title' => 'Strong Exam Readiness', 'description' => 'Build confidence and skills for test day success'],
        ];
    }
}
