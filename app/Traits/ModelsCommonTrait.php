<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ModelsCommonTrait
{

    public static function generateSlug($isNumbers = false): string
    {
        $str = Str::random(6);
        if ($isNumbers)
            $str = rand(111111, 999999);

        if (self::query()->where('slug', $str)->exists()) {
            return self::generateSlug();
        }

        return $str;

    }

    public function getImage($key = null): ?string
    {
        $imageField = $key ? $this->{$key} : $this->image;
        return $imageField ? asset($imageField) : asset('assets/placeholder.webp');
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
