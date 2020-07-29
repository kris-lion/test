<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Пользователи
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            $users = User::query();

            $users = $users->with('roles')->paginate($request->has('limit') ? $request->get('limit') : $users->count());

            return UserResource::collection($users);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Добавить пользователя
     *
     */
    public function post(UserRequest $request)
    {
        try {
            $user = User::create([
                'login'    => $request->get('login'),
                'password' => Hash::make($request->get('password'))
            ]);

            if ($request->has('roles') and count($request->get('roles'))) {
                $user->roles()->attach($request->get('roles'));
            }

            return new UserResource($user->load('roles.permissions'));
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Редактировать пользователя
     *
     */
    public function put(UserRequest $request, $userId)
    {
        try {
            if ($user = User::find($userId)) {
                $user->update([
                    'login' => $request->get('login')
                ]);

                if ($request->has('roles') and count($request->get('roles'))) {

                    if ($user->roles->count()) {
                        foreach (Role::all() as $role) {
                            $key = array_search($role->id, $request->get('roles'));
                            if ($key === false) {
                                if ($user->roles->where('id', $role->id)->first()) {
                                    $user->roles()->detach($role->id);
                                }
                            } else {
                                if (!$user->roles->where('id', $role->id)->first()) {
                                    $user->roles()->attach($role->id);
                                }
                            }
                        }
                    } else {
                        $user->roles()->attach($request->get('roles'));
                    }

                } else if ($user->roles->count()) {
                    $user->roles()->detach($user->roles->pluck('id')->toArray());
                }

                return new UserResource($user->load('roles.permissions'));
            }

            return response()->noContent();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Удалить роль
     *
     */
    public function delete($userId)
    {
        try {
            if ($user = User::find($userId)) {
                $user->delete();
            }

            return response()->noContent();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
