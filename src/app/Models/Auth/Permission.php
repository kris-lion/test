<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'auth_permissions';

    protected $fillable = [
        'name', 'description'
    ];

    public $timestamps = false;
}
