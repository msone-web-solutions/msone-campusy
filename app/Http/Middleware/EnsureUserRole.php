<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Keeps the two audiences apart: students never see the parent report,
 * parents never land in lessons or tests. Instead of a 403, the user is
 * sent to the start page of their own role.
 */
class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->role !== UserRole::from($role)) {
            return redirect()->route($user->isParent() ? 'parent.dashboard' : 'dashboard');
        }

        return $next($request);
    }
}
