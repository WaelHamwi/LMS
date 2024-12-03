<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MultiGuardStudentAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('student')->check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
