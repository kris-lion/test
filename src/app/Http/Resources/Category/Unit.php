<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Category\Unit\Group;
use App\Http\Resources\Category\Unit\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class Unit extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'short' => $this->short,
            'type'  => new Type($this->whenLoaded('type')),
            'group' => new Group($this->whenLoaded('group'))
        ];
    }
}
