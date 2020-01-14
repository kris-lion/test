<?php

namespace App\Models\Product\Category;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
