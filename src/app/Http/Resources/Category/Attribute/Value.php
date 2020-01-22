<?php

namespace App\Http\Resources\Category\Attribute;

use App\Http\Resources\Category\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class Value extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'value'     => $this->value,
            'attribute' => new Attribute($this->whenLoaded('attribute'))
        ];
    }
}
