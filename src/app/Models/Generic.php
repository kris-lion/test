<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    protected $table = 'generic_names';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
