<?php

namespace App\Models\Category\Attribute;

use App\Models\Category\Attribute;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $table = 'attribute_values';

    /**
     * @var array
     */
    protected $fillable = [
        'value', 'attribute_id', 'item_id'
    ];

    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }
}
