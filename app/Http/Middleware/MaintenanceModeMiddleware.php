<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class MaintenanceModeMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $isActive = Setting::where('key', 'm_mode')->first()?->value == 'on';
        if ($isActive)
            return redirect()->route('m_mode');

        return $next($request);
    }
}
