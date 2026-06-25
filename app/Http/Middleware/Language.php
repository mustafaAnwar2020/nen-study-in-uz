<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    public function handle($request, Closure $next)
    {
        $defaultLocale = Config::get('app.locale', 'ar');
        $locale = Session::get('applocale', $defaultLocale);
        $supported = config('locales.supported', ['en', 'ar']);

        if (! in_array($locale, $supported, true)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);

        return $next($request);
    }
}
