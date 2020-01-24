<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Auth\Permission as PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
