<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiOverviewSection extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'benefits' => 'array',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent()
    {
        return static::query()->where('is_active', true)->first();
    }

    public function getStudentImage()
    {
        return $this->student_image ? asset($this->student_image) : asset('site/images/toefl-students-celebrating.jpeg');
    }

    public function getBenefitsList(): array
    {
        if (empty($this->benefits) || !is_array($this->benefits)) {
            return static::getDefaultBenefits();
        }
        return array_values(array_filter($this->benefits));
    }

    public function getFeaturesList(): array
    {
        if (empty($this->features) || !is_array($this->features)) {
            return static::getDefaultFeatures();
        }
        return $this->features;
    }

    public static function getDefaultBenefits(): array
    {
        return [
            '100% Free Practice',
            'No Practice Fees',
            'No Hidden Costs',
            'Refundable Deposit',
            'Rewards Included',
            'No Training Fees',
            'Certified TOEFL Mentors',
            'Build Confidence & Readiness',
        ];
    }

    public static function getDefaultFeatures(): array
    {
        return [
            ['icon' => 'bi-book-half', 'icon_class' => 'icon-primary', 'title' => 'TOEFL Practice Workshop'],
            ['icon' => 'bi-clipboard-check', 'icon_class' => 'icon-success', 'title' => 'Supervised TOEFL Practice Test'],
            ['icon' => 'bi-house-door', 'icon_class' => 'icon-info', 'title' => 'Home-Based Practice Tests'],
            ['icon' => 'bi-chat-dots', 'icon_class' => 'icon-warning', 'title' => 'Mentor Feedback & Guidance'],
            ['icon' => 'bi-trophy', 'icon_class' => 'icon-danger', 'title' => 'Exam Confidence Building'],
        ];
    }
}
