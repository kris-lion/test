<?php

namespace App\Http\Resources;

use App\Http\Resources\Auth\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'login' => $this->login,
            'roles' => Role::collection($this->whenLoaded('roles')),
        ];
    }
}
