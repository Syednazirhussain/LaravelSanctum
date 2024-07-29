<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class OrderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the waiter_id is a user with the 'waiter' role
        if ($request->has('waiter_id')) {
            $waiterId = $request->input('waiter_id');
            $waiter = User::whereHas('roles', function ($query) {
                $query->where('name', 'waiter');
            })->find($waiterId);

            if (!$waiter) {
                return response()->json(['error' => "The `waiter_id` user isn't associated with `waiter` role."], 400);
            }
        }

        return $next($request);
    }
}
