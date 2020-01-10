<?php

namespace App\Models;

use App\Models\Dosage\Form;
use App\Models\Product\ProductClass;
use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    protected $table = 'preparations';

    /**
     * @var array
     */
    protected $fillable = [
        'standard', 'name', 'dosage', 'dosage_short', 'packing', 'addition', 'volume', 'quantity',
        'unit_id', 'product_class_id', 'generic_name_id', 'dosage_form_id'
    ];

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function productClass()
    {
        return $this->hasOne(ProductClass::class, 'id', 'product_class_id');
    }

    public function genericName()
    {
        return $this->hasOne(Generic::class, 'id', 'generic_name_id');
    }

    public function dosageForm()
    {
        return $this->hasOne(Form::class, 'id', 'dosage_form_id');
    }
}
