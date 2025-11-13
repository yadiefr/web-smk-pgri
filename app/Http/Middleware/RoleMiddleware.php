<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Unauthorized action.');
        }

        // Allow admin users to access only kesiswaan and tata_usaha role-protected routes
        if ((isset($user->role) && $user->role === 'admin') || (method_exists($user, 'isAdmin') && $user->isAdmin())) {
            $allowedRoles = ['kesiswaan', 'tata_usaha'];
            if (in_array($role, $allowedRoles)) {
                return $next($request);
            }
        }

        if ($user->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
