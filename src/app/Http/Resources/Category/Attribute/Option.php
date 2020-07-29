<?php

namespace App\Http\Resources\Category\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

class Option extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'option' => $this->option
        ];
    }
}
