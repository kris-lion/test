<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Вход
     *
     * @return AnonymousResourceCollection
     */
    public function post(LoginRequest $request)
    {
        try {
            try {
                if (!$token = JWTAuth::attempt($request->only('login', 'password'))) {
                    return response()->make(['message' => trans('auth.failed')], 403);
                }
            } catch (JWTException $e) {
                Log::error($e);
                return response()->make(['message' => trans('http.status.500')], 500);
            }

            return response()->json(['account' => new UserResource(Auth::user()->load('roles.permissions'))])->header('Authorization', "Bearer {$token}");
        } catch (HttpException $e) {
            Log::error($e);
            return response()->make(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
