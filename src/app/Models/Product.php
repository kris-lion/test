<?php

namespace App\Models;

use App\Models\Dosage\Form;
use App\Models\Product\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'standard', 'name', 'dosage', 'dosage_short', 'packing', 'addition', 'volume', 'quantity',
        'unit_id', 'category_id', 'generic_id', 'form_id'
    ];

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function generic()
    {
        return $this->hasOne(Generic::class, 'id', 'generic_id');
    }

    public function form()
    {
        return $this->hasOne(Form::class, 'id', 'form_id');
    }
}
