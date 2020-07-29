<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Token extends BaseMiddleware
{
    public function handle($request, Closure $next, $required = true)
    {
        if (($required === true) or $this->auth->setRequest($request)->getToken()) {
            if (!$token = $this->auth->setRequest($request)->getToken()) {
                return response()->make(['message' => trans('auth.token.not.provided')], 403);
            }

            try {
                try {
                    if (!$this->auth->setToken($token)->authenticate()) {
                        return response()->make(['message' => trans('auth.token.not.found')], 403);
                    }
                } catch (JWTException $e) {
                    if ($e instanceof TokenExpiredException) {
                        return $this->token($request, $next);
                    }

                    return response()->make(['message' => trans('auth.token.blacklisted')], 403);
                }

            } catch (TokenExpiredException $e) {
                return $this->token($request, $next);
            } catch (JWTException $e) {
                return response()->make(['message' => trans('auth.token.invalid')], 403);
            }
        }

        return $next($request);
    }

    protected function token($request, Closure $next)
    {
        try {
            $token = $this->auth->setRequest($request)->parseToken()->refresh();
            if (!$this->auth->setToken($token)->authenticate()) {
                return response()->make(['message' => trans('auth.token.not.found')], 403);
            }
            $response = $next($request);
            $response->headers->set('Authorization', "Bearer {$token}");

            return $response;
        } catch (TokenExpiredException $e) {
            return response()->make(['message' => trans('auth.token.expired')], 403);
        }
    }
}
