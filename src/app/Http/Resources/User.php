<?php

namespace App\Http\Resources;

use App\Http\Resources\Auth\Role as RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'login' => $this->login,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
