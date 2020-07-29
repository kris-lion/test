<?php

namespace App\Models\Category\Attribute;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'attribute_types';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'key', 'active'
    ];

    public $timestamps = false;
}
