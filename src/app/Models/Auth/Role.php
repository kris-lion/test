<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'auth_roles';

    protected $fillable = [
        'name', 'description'
    ];

    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'auth_role_permission', 'role_id', 'permission_id');
    }
}
