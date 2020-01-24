<?php

namespace App\Models\Category;

use App\Models\Category\Attribute\Type;
use App\Models\Category\Attribute\Value;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'category_id', 'type_id', 'required'
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, 'attribute_id', 'id');
    }
}
