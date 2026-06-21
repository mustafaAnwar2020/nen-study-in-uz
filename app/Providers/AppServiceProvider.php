<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $isRtl = $locale === 'ar';

            $view->with('currentLocale', $locale);
            $view->with('isRtl', $isRtl);
            $view->with('htmlDir', $isRtl ? 'rtl' : 'ltr');
            $view->with('htmlLang', $locale);
        });
    }
}
