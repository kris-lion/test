<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Category\Attribute as AttributeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
        ];
    }
}
