<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    /**
     * @var array
     */
    protected $fillable = [
       'name'
    ];

    public $timestamps = false;
}
