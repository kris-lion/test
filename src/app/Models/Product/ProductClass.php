<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductClass extends Model
{
    protected $table = 'product_classes';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
