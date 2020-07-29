<?php

namespace App\Services\Authorize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed ability(array|string $roles, array|string $permissions, array $options = [])
 * @method static boolean roles(array|string $name, boolean $requireAll = false)
 * @method static boolean permissions(array|string $name, boolean $requireAll = false)
 */

class Authorize extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authorize';
    }
}
