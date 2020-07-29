<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccountController extends Controller
{
    /**
     * Аккаунт
     *
     * @return AnonymousResourceCollection
     */
    public function get()
    {
        try {
            return response()->json(['account' => new UserResource(Auth::user()->load('roles.permissions'))]);
        } catch (HttpException $e) {
            Log::error($e);
            return response()->make(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
