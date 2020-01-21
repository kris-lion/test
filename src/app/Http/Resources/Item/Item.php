<?php

namespace App\Http\Resources\Item;

use App\Http\Resources\Category\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'category' => new Category($this->whenLoaded('category'))
        ];
    }
}
