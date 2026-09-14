<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Accounts are created by hand with a start password. Until the user has
 * replaced it, every page except the rotation form (and logout) redirects there.
 */
class RequirePasswordRotation
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->must_change_password) {
            return $next($request);
        }

        if ($request->routeIs('password.rotate', 'logout', '*livewire.*')) {
            return $next($request);
        }

        return redirect()->route('password.rotate');
    }
}
