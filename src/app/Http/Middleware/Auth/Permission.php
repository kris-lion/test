<?php

namespace App\Http\Middleware\Auth;

use App\Services\Authorize\Facades\Authorize;
use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    public function handle($request, Closure $next, $permissions)
    {
        if (Auth::guest()) {
            return response()->make('Unauthorized', '401');
        } elseif (!Authorize::permissions(explode('|', $permissions))) {
            return response()->make('Forbidden', '403');
        }

        return $next($request);
    }
}
