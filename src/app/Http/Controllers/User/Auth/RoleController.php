<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\User\Auth\RoleRequest;
use App\Http\Resources\Auth\Role as RoleResource;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Роли
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            $roles = Role::whereNotIn('name', ['user']);

            $roles = $roles->with('permissions')->paginate($request->has('limit') ? $request->get('limit') : $roles->count());

            return RoleResource::collection($roles);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Добавить роль
     *
     */
    public function post(RoleRequest $request)
    {
        try {
            $role = Role::create([
                'name'        => $request->get('name'),
                'description' => $request->get('description')
            ]);

            if ($request->has('permissions') and count($request->get('permissions'))) {
                $role->permissions()->attach($request->get('permissions'));
            }

            return new RoleResource($role->load('permissions'));
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Редактировать роль
     *
     */
    public function put(RoleRequest $request, $roleId)
    {
        try {
            if ($role = Role::find($roleId)) {
                $role->update([
                    'name'        => $request->get('name'),
                    'description' => $request->get('description')
                ]);

                if ($request->has('permissions') and count($request->get('permissions'))) {

                    if ($role->permissions->count()) {
                        foreach (Permission::all() as $permission) {
                            $key = array_search($permission->id, $request->get('permissions'));
                            if ($key === false) {
                                if ($role->permissions->where('id', $permission->id)->first()) {
                                    $role->permissions()->detach($permission->id);
                                }
                            } else {
                                if (!$role->permissions->where('id', $permission->id)->first()) {
                                    $role->permissions()->attach($permission->id);
                                }
                            }
                        }
                    } else {
                        $role->permissions()->attach($request->get('permissions'));
                    }

                } else if ($role->permissions->count()) {
                    $role->permissions()->detach($role->permissions->pluck('id')->toArray());
                }

                return new RoleResource($role->load('permissions'));
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
    public function delete($roleId)
    {
        try {
            if ($role = Role::find($roleId)) {
                $role->delete();
            }

            return response()->noContent();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
