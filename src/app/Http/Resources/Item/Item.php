<?php

namespace App\Http\Resources\Item;

use App\Http\Resources\Category\Attribute\Value as ValueResource;
use App\Http\Resources\Category\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'active'   => $this->active,
            'category' => new Category($this->whenLoaded('category')),
            'values'   => ValueResource::collection($this->whenLoaded('values')),
            'name'     => $this->getName()
        ];
    }

    protected function getName()
    {
        $name = null;

        foreach ($this->values as $value) {
            if ($value->attribute->search) {
                if ($name) {
                    $name = "{$name} ";
                }
                $name = "{$name}{$value->value}";
            }
        }

        return $name;
    }
}
