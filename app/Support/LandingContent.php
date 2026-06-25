<?php

namespace App\Support;

class LandingContent
{
    public static function get(object $landing, string $key): mixed
    {
        $locale = app()->getLocale();

        if ($locale !== 'en') {
            $suffix = config("locales.db_suffix.{$locale}");

            if ($suffix) {
                $localizedKey = $key . $suffix;
                $localizedValue = $landing->{$localizedKey} ?? null;

                if (is_string($localizedValue) && trim($localizedValue) !== '') {
                    return $localizedValue;
                }

                return null;
            }
        }

        $value = $landing->{$key} ?? null;

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        return $value;
    }
}
