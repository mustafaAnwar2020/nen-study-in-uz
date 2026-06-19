<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ProtectedFile;

class ProtectedFileAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $protectedFileId = $request->route('protectedFile');
        
        if ($protectedFileId) {
            $protectedFile = ProtectedFile::where('id', $protectedFileId)
                ->where('is_active', true)
                ->first();
            
            if (!$protectedFile) {
                return redirect()->route('protected-files.index')
                    ->with('error', 'Protected file not found or inactive.');
            }
            
            $sessionKey = 'protected_file_access_' . $protectedFileId;
            
            if (!session()->has($sessionKey) || session($sessionKey) !== true) {
                return redirect()->route('protected-files.password-form', $protectedFileId)
                    ->with('error', 'Please enter the password to access this file.');
            }
            
            $protectedFile->updateLastAccessed();
        }
        
        return $next($request);
    }
}
