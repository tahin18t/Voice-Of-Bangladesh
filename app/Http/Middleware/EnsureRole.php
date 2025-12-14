<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (empty($roles)) {
            return $next($request);
        }

        $userRole = $user->role?->name ?? null;
        if (!in_array($userRole, $roles, true)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
