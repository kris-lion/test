<?php

namespace App\Http\Middleware\Auth;

use App\Services\Authorize\Facades\Authorize;
use Closure;
use Illuminate\Support\Facades\Auth;

class Ability
{
    public function handle($request, Closure $next, $roles, $permissions, $validateAll = false)
    {
        if (Auth::guest()) {
            return response()->make('Unauthorized', '401');
        } elseif (!Authorize::ability(explode('|', $roles), explode('|', $permissions), ['validate_all' => $validateAll])) {
            return response()->make('Forbidden', '403');
        }

        return $next($request);
    }
}
