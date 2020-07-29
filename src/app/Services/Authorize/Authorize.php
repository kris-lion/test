<?php

namespace App\Services\Authorize;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Authorize
{
    public static function ability($roles, $permissions, $options = [])
    {
        if (!is_array($roles)) {
            $roles = explode(',', $roles);
        }

        if (!is_array($permissions)) {
            $permissions = explode(',', $permissions);
        }

        if (!isset($options['validate_all'])) {
            $options['validate_all'] = false;
        } else {
            if ($options['validate_all'] !== true && $options['validate_all'] !== false) {
                throw new InvalidArgumentException();
            }
        }

        if (!isset($options['return_type'])) {
            $options['return_type'] = 'boolean';
        } else {
            if ($options['return_type'] != 'boolean' &&
                $options['return_type'] != 'array' &&
                $options['return_type'] != 'both') {
                throw new InvalidArgumentException();
            }
        }

        $checkedRoles = [];
        $checkedPermissions = [];

        foreach ($roles as $role) {
            $checkedRoles[$role] = self::roles($role);
        }

        foreach ($permissions as $permission) {
            $checkedPermissions[$permission] = self::permissions($permission);
        }

        if(($options['validate_all'] && !(in_array(false,$checkedRoles) || in_array(false,$checkedPermissions))) ||
            (!$options['validate_all'] && (in_array(true,$checkedRoles) || in_array(true,$checkedPermissions)))) {
            $validateAll = true;
        } else {
            $validateAll = false;
        }

        if ($options['return_type'] == 'boolean') {
            return $validateAll;
        } elseif ($options['return_type'] == 'array') {
            return ['roles' => $checkedRoles, 'permissions' => $checkedPermissions];
        } else {
            return [$validateAll, ['roles' => $checkedRoles, 'permissions' => $checkedPermissions]];
        }

    }

    public static function roles($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = self::roles($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            $user = Auth::user();

            foreach ($user->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function permissions($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $permission) {
                $has = self::permissions($permission);

                if ($has && !$requireAll) {
                    return true;
                } elseif (!$has && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            $user = Auth::user();

            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (Str::is($name, $permission->name) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
