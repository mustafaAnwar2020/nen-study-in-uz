<?php

namespace App\Traits;

trait HasLocalizedAttributes
{
    public function localized(string $attribute, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'ar') {
            $arKey = $attribute . '_ar';
            $arValue = $this->{$arKey} ?? null;

            if (is_string($arValue) && trim($arValue) !== '') {
                return $arValue;
            }
        }

        return $this->{$attribute} ?? null;
    }
}
