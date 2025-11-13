<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check auth status for different guards
        $guards = ['web', 'guru', 'siswa'];
        $authenticated = false;

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $user = auth()->guard($guard)->user();
                
                // For students, check if the guard matches and user has any required role
                if ($guard === 'siswa' && in_array('siswa', $roles)) {
                    // Additional check: ensure user has hasRole method and role property
                    if (method_exists($user, 'hasRole') && $user->hasRole('siswa')) {
                        $authenticated = true;
                        break;
                    }
                }
                // For other users (web, guru), check if user has any of the required roles
                elseif ($guard !== 'siswa' && $user) {
                    // Allow admin users to bypass role checks only for kesiswaan and tata_usaha
                    if ((isset($user->role) && $user->role === 'admin') || (method_exists($user, 'isAdmin') && $user->isAdmin())) {
                        $allowedRoles = ['kesiswaan', 'tata_usaha'];
                        foreach ($roles as $role) {
                            if (in_array($role, $allowedRoles)) {
                                $authenticated = true;
                                break 2;
                            }
                        }
                    }
                    foreach ($roles as $role) {
                        if ($user->role === $role || (method_exists($user, 'hasRole') && $user->hasRole($role))) {
                            $authenticated = true;
                            break 2;
                        }
                    }
                }
            }
        }

        if (!$authenticated) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 