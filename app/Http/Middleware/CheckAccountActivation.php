<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckAccountActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to the deactivated and expiry routes to avoid redirect loops
        if ($request->routeIs('deactivated') || $request->routeIs('expiry') || $request->routeIs('logout')) {
            return $next($request);
        }

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);

            if ($user->hasRole('super-admin')) {
                return $next($request);
            }

            // Check if user is not active
            if ($user->is_active !== 'active') {
                return redirect()->route('deactivated');
            }

            // Check if expiry_date exists and is in the past
            if ($user->expiry_date && Carbon::parse($user->expiry_date)->isPast()) {
                return redirect()->route('expiry');
            }
        }
        return $next($request);
    }
}
