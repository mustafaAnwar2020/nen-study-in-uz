<?php

namespace App\Models;

use App\Traits\ModelsCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use ModelsCommonTrait;

    protected $guarded = [];

    public const TYPE_MAIN = 'Main Offices';

    public const TYPE_AUTHORIZED = 'Authorized Offices';

    /** @deprecated Use all active geocoded locations for the landing map. */
    public const COLLECTION_POINT_SLUGS = [
        'global-ibs-nasr-city',
        'nen-6-october',
        'dar-al-tanmya-mansoura',
    ];

    public function countryLabel(): string
    {
        $code = strtolower((string) $this->country_code);
        $key = 'landing.collection_points.countries.' . $code;
        $translated = __($key);

        if ($translated !== $key) {
            return $translated;
        }

        return config('countries.' . $code) ?? strtoupper($code);
    }

    public static function collectionPoints()
    {
        $countryOrder = ['eg', 'om', 'ae', 'sa', 'az', 'uz', 'kg'];

        return static::query()
            ->active()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->get()
            ->sortBy(function ($location) use ($countryOrder) {
                $code = strtolower((string) $location->country_code);
                $countryIdx = array_search($code, $countryOrder, true);

                return ($countryIdx !== false ? $countryIdx : 999) * 1000 + $location->id;
            })
            ->values();
    }

    public function mapsShareUrl(): string
    {
        if ($this->map_url) {
            return $this->map_url;
        }

        if ($this->latitude && $this->longitude) {
            return 'https://www.google.com/maps?q=' . $this->latitude . ',' . $this->longitude;
        }

        return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode((string) $this->address);
    }

    public static function sortedActive()
    {
        $sortOrder = ['ae', 'om', 'sa', 'eg', 'az', 'uz', 'kg'];

        return static::query()->active()->get()->sortBy(function ($location) use ($sortOrder) {
            $index = array_search($location->country_code, $sortOrder);

            return $index !== false ? $index : 999;
        })->values();
    }
}
