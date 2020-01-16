<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Product\Category\Group;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'group' => new Group($this->whenLoaded('group')),
        ];
    }
}
