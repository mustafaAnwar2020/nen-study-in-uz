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

    /** Slugs for Egypt ETS collection points shown on the landing map. */
    public const COLLECTION_POINT_SLUGS = [
        'global-ibs-nasr-city',
        'nen-6-october',
        'dar-al-tanmya-mansoura',
    ];

    public static function collectionPoints()
    {
        return static::query()
            ->active()
            ->whereIn('slug', self::COLLECTION_POINT_SLUGS)
            ->get()
            ->sortBy(fn ($location) => array_search($location->slug, self::COLLECTION_POINT_SLUGS, true))
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
