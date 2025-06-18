<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AgencyUser;

class IsAgency
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('agency')->check()) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Unauthorized.');
    }
}
