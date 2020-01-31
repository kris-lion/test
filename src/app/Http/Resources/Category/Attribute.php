<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Category\Attribute\Option as OptionResource;
use App\Http\Resources\Category\Attribute\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class Attribute extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'type'     => new Type($this->whenLoaded('type')),
            'required' => $this->required,
            'value'    => $this->value,
            'options'  => OptionResource::collection($this->whenLoaded('options'))
        ];
    }
}
