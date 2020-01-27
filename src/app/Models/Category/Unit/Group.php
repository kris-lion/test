<?php

namespace App\Models\Category\Unit;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'unit_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
