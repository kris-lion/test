<?php

namespace App\Models\Category\Attribute;

use App\Models\Category\Attribute;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'attribute_options';

    /**
     * @var array
     */
    protected $fillable = [
        'option', 'attribute_id'
    ];

    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }
}
