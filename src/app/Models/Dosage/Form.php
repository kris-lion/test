<?php

namespace App\Models\Dosage;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'dosage_forms';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
