<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        
        // Check the requested URI to determine which login page to redirect to
        $uri = $request->path();
        
        if (str_starts_with($uri, 'guru')) {
            return route('guru.login');
        } elseif (str_starts_with($uri, 'siswa')) {
            return route('siswa.login');
        } elseif (str_starts_with($uri, 'ppdb')) {
            // Exclude public PPDB pages that don't require authentication
            $publicPpdbRoutes = ['ppdb', 'ppdb/check', 'ppdb/success', 'ppdb/print', 'ppdb/register', 'ppdb/login'];
            if (!in_array($uri, $publicPpdbRoutes) && !preg_match('/^ppdb\/(success|print)\//', $uri)) {
                return route('pendaftar.login');
            }
        }
        
        return route('login');
    }
}
