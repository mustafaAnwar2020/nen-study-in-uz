<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            return redirect('/admin/login')->with('error', 'Please login first.');
        }

        $user = auth()->user();

        // Super admin bypasses all permission checks
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        if (!$user->hasPermissionTo($permission)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.',
                ], 403);
            }

            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
