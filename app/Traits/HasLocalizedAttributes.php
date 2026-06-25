<?php

namespace App\Traits;

trait HasLocalizedAttributes
{
    public function localized(string $attribute, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale !== 'en') {
            $suffix = config("locales.db_suffix.{$locale}");

            if ($suffix) {
                $localizedKey = $attribute . $suffix;
                $localizedValue = $this->{$localizedKey} ?? null;

                if (is_string($localizedValue) && trim($localizedValue) !== '') {
                    return $localizedValue;
                }
            }
        }

        return $this->{$attribute} ?? null;
    }
}
