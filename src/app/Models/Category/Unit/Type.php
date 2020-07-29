<?php

namespace App\Models\Category\Unit;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'unit_types';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
