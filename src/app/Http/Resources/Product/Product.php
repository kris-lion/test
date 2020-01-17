<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Product\Dosage\Form;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'standard' => $this->standard,
            'volume'   => $this->volume,
            'quantity' => $this->quantity,
            'packing'  => $this->packing,
            'unit'     => new Unit($this->whenLoaded('unit')),
            'generic'  => new Generic($this->whenLoaded('generic')),
            'form'     => new Form($this->whenLoaded('form')),
            'category' => new Category($this->whenLoaded('category')),
        ];
    }
}
