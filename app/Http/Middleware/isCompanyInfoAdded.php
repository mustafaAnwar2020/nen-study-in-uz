<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isCompanyInfoAdded
{

    public function handle(Request $request, Closure $next)
    {
        if (!auth('company')->check()) {
            return redirect()->route('companies.login');
        }

        if (!currentCompany()->checkAddedInfo()) {
            return redirect()->route('companies.profile.edit')->with('info', 'لا يمكنك البدء قبل رفع المرفقات المطلوبة');
        }

        return $next($request);

    }
}
