<?php

namespace App\Http\Resources\Category\Attribute;

use App\Http\Resources\Category\Attribute;
use App\Http\Resources\Item\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class Value extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'attribute' => new Attribute($this->whenLoaded('attribute'))
        ];
    }
}
