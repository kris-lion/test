<?php

namespace App\Models\Dictionary;

use App\Models\Category\Attribute\Value;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Generic extends Model
{
    protected $table = 'dic_generics';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name'
    ];

    public $timestamps = false;
}
