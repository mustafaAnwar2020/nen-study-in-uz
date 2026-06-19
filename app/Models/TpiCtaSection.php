<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiCtaSection extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'payment_options' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent()
    {
        return static::query()->where('is_active', true)->first();
    }

    public function getImage()
    {
        return $this->image ? asset($this->image) : asset('site/images/tpi-hero.png');
    }

    public function getPaymentOptionsList(): array
    {
        if (empty($this->payment_options) || !is_array($this->payment_options)) {
            return static::getDefaultPaymentOptions();
        }
        return $this->payment_options;
    }

    public static function getDefaultPaymentOptions(): array
    {
        return [
            ['label' => 'Pay in EGP (500 EGP)', 'url' => 'https://pay.getpayin.com/guest/checkout/global%20integrated%20business%20solutions/6889ca52c566d/696e75f44c3c6?payment_method_id=5683', 'icon' => 'flag-icon-eg'],
            ['label' => 'Pay in USD ($10.00)', 'url' => 'https://pay.getpayin.com/guest/checkout/global%20integrated%20business%20solutions/6889ca52c566d/696e75283580f?payment_method_id=5683', 'icon' => 'flag-icon-us'],
        ];
    }
}
