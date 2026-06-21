<?php

namespace App\Support;

class LandingContent
{
    public static function get(object $landing, string $key): mixed
    {
        if (app()->getLocale() === 'ar') {
            $arKey = $key . '_ar';
            $arValue = $landing->{$arKey} ?? null;

            if (is_string($arValue) && trim($arValue) !== '') {
                return $arValue;
            }
        }

        return $landing->{$key} ?? null;
    }
}
