<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MultiGuardMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('teacher')->check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
