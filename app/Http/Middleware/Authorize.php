<?php

namespace App\Http\Middleware;

class Authorize
{
    public function handle($request, \Closure $next, $role)
    {
        if ($role === 'admin') {
            if (!$request->user()->is_admin) {
                return response()->json([ 'message' => 'you don\'t have an access' ], 403);
            }
        }

        return $next($request);
    }
}
