<?php

namespace App\Models;

use App\Models\Category\Attribute\Value;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Builder;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'items';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'category_id', 'created_at'
    ];

    public function toSearchableArray()
    {
        $attributes = [];

        foreach ($this->category->attributes()->get() as $attribute) {
            $value = $this->values->where('attribute_id', $attribute->id)->first();
            $attributes["attribute_{$attribute->id}"] = $value ? $value->value : null;
        }

        $attributes["id"] = $this->id;

        return $attributes;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, 'item_id', 'id');
    }
}
