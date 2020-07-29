<?php

namespace App\Http\Middleware\Auth;

use App\Services\Authorize\Facades\Authorize;
use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, $roles)
    {
        if (Auth::guest()) {
            return response()->make('Unauthorized', '401');
        } elseif (!Authorize::roles(explode('|', $roles))) {
            return response()->make('Forbidden', '403');
        }

        return $next($request);
    }
}
