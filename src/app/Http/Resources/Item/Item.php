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
<<<<<<< HEAD
            'name'     => $this->getName(),
            /** */ 
            'count'    => $this->count
=======
            'name'     => $this->getName()
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
