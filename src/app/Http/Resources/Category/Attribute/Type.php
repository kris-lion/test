<?php

namespace App\Http\Resources\Category\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

class Type extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'key'  => $this->key
        ];
    }
}
