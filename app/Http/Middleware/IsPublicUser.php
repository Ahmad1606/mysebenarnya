<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PublicUser;

class IsPublicUser
{
    /**
     * Handle an incoming request.
     * Protects Public User Routes:
     * - Submit new inquiries with evidence
     * - View own inquiry history and status
     * - Access public inquiry listings
     * - Update personal profile
     * - Track inquiry progress
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('public')->check()) {
            // Check if email is verified
            $user = Auth::guard('public')->user();
            if ($user->PublicStatusVerify == 0 && $request->path() !== 'email/verify') {
                return redirect('/email/verify')->with('warning', 'Please verify your email address before proceeding.');
            }
            
            return $next($request);
        }

        return redirect('/login')->with('error', 'Access denied. Please login to access this area.');
    }
}
