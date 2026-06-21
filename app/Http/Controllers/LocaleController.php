<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, ['en', 'ar'], true)) {
            abort(404);
        }

        Session::put('applocale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}
