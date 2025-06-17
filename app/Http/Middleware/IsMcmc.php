<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMcmc
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('mcmc')->check()) {
            return $next($request);
        }
        return redirect('/login')->with('error', 'Access denied for MCMC.');
    }
}