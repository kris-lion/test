<?php

namespace App\Http\Resources\Category\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class Group extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name
        ];
    }
}
