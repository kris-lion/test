<?php

namespace App\Http\Resources\Product\Dosage;

use Illuminate\Http\Resources\Json\JsonResource;

class Form extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name
        ];
    }
}
