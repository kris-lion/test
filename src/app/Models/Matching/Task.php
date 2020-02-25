<?php

namespace App\Models\Matching;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'matching';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'active', 'run'
    ];
}
