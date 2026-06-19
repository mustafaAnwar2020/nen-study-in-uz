<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdminStaff
{

    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            // Don't redirect if already on login page to avoid loops
            if (!$request->is('admin/login*')) {
                return redirect('/admin/login');
            }
            return $next($request);
        }

        $user = auth()->user();

        // 1. Legacy is_admin flag
        if ($user->isAdmin()) {
            return $next($request);
        }

        // 2. Super admin role
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        // 3. Any management-level role (not student/instructor)
        if ($user->roles()->whereNotIn('name', ['student', 'instructor'])->exists()) {
            return $next($request);
        }

        // Not allowed — redirect to site homepage
        return redirect('/');
    }
}
