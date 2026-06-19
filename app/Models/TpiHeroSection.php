<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class TpiHeroSection extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    protected $casts = [
        'countries' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getContent()
    {
        return static::query()->where('is_active', true)->first();
    }

    public function getImage()
    {
        return $this->image ? asset($this->image) : asset('site/images/tpi-hero.jpg');
    }

    public function getCountriesList(): array
    {
        if (empty($this->countries) || !is_array($this->countries)) {
            return static::getDefaultCountries();
        }
        return $this->countries;
    }

    public static function getDefaultCountries(): array
    {
        return [
            ['code' => 'eg', 'name' => 'Egypt', 'url' => 'https://nen-global.org/eging', 'flag' => 'flag-icon-eg'],
            ['code' => 'om', 'name' => 'Oman', 'url' => 'https://nen-global.org/oming', 'flag' => 'flag-icon-om'],
            ['code' => 'sa', 'name' => 'KSA', 'url' => 'https://nen-global.org/saing', 'flag' => 'flag-icon-sa'],
            ['code' => 'kg', 'name' => 'Kyrgyzstan', 'url' => 'https://nen-global.org/kging', 'flag' => 'flag-icon-kg'],
            ['code' => 'uz', 'name' => 'Uzbekistan', 'url' => 'https://nen-global.org/uzing', 'flag' => 'flag-icon-uz'],
            ['code' => 'tj', 'name' => 'Tajikistan', 'url' => 'https://nen-global.org/tjing', 'flag' => 'flag-icon-tj'],
            ['code' => 'tr', 'name' => 'Turkey', 'url' => 'https://nen-global.org/tring', 'flag' => 'flag-icon-tr'],
            ['code' => 'az', 'name' => 'Azerbaijan', 'url' => 'https://nen-global.org/azing', 'flag' => 'flag-icon-az'],
            ['code' => 'ae', 'name' => 'UAE', 'url' => 'https://nen-global.org/aeing', 'flag' => 'flag-icon-ae'],
        ];
    }
}
