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

    public static function sortedActive()
    {
        $sortOrder = ['ae', 'om', 'sa', 'eg', 'az', 'uz', 'kg'];

        return static::query()->active()->get()->sortBy(function ($location) use ($sortOrder) {
            $index = array_search($location->country_code, $sortOrder);

            return $index !== false ? $index : 999;
        })->values();
    }
}
