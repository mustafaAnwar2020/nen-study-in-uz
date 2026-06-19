<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!App::runningInConsole()) {
            $data = Setting::query()->get();
            $settings = [];
            foreach ($data as $setting) {
                $settings[$setting->key] = json_decode($setting->value) ?? $setting->value;
            }

            $defaults = [
                'general' => (object) [
                    'site_name' => 'NEN',
                    'site_about' => '',
                    'phone' => '',
                    'email' => '',
                ],
                'media' => (object) [
                    'logo' => '/assets/logo.png',
                    'ets_logo' => '/assets/ets-svg.svg',
                    'fav_icon' => '/assets/favicon.png',
                ],
                'social' => (object) [
                    'facebook' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                    'linkedin' => '#',
                    'youtube' => '#',
                    'tiktok' => '#',
                    'whatsapp' => '',
                    'telegram' => '',
                ],
            ];

            foreach ($defaults as $key => $default) {
                if (empty($settings[$key])) {
                    $settings[$key] = $default;
                } else {
                    $settings[$key] = (object) array_merge(
                        (array) $default,
                        (array) $settings[$key]
                    );
                }
            }

            // Load countries from database for registration dropdown
            $countries = Country::active()->ordered()->get()->mapWithKeys(function ($country) {
                return [$country->code => [
                    'name' => $country->name,
                    'url' => $country->registration_url,
                    'flag_icon' => $country->flag_icon,
                ]];
            })->toArray();

            // Load product types for the header dropdown
            $headerProductTypes = \App\Models\Product::TYPESEXCEPTGENERAL;

            View::share([
                'settings' => $settings,
                'countries' => $countries,
                'headerProductTypes' => $headerProductTypes,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
