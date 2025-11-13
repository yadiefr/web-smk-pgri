<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is an admin
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user is authenticated on web guard and has admin role
        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            
            // Check if user is actually an admin
            if ((isset($user->role) && $user->role === 'admin') || (method_exists($user, 'isAdmin') && $user->isAdmin())) {
                return $next($request);
            }
        }

        // If not admin, return 403 Unauthorized
        abort(403, 'Unauthorized action.');
    }
}
