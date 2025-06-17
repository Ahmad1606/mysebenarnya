<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PublicUser;

class IsPublicUser
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('public')->check()) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Unauthorized.');
    }
}
