<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     */
    public function handle(Request $request, Closure $next, ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($guard == 'student' && Auth::guard($guard)->check()) {
                return redirect('/student');
            }
            if ($guard == 'web' && Auth::guard($guard)->check()) {
                return redirect('/admin/dashboard');
            }
        }

        return $next($request);
    }
}
