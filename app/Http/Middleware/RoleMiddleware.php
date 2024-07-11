<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        Log::info($user);
        Log::info($user->roles);
        Log::info($user->roles->pluck('role_name')->intersect($roles));
        Log::info($user->roles->pluck('role_name')->intersect($roles)->isNotEmpty());
        
        if ($user && $user->roles->pluck('role_name')->intersect($roles)->isNotEmpty()) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
