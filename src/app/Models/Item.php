<?php

namespace App\Models;

use App\Models\Category\Attribute\Value;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'items';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'active', 'category_id', 'created_at', 'count'
    ];

    public function toSearchableArray()
    {
        $attributes = [];

        foreach ($this->category->attributes()->with('type')->get() as $attribute) {
            $attributes["attribute_{$attribute->id}"] = null;

            if ($value = $this->values->where('attribute_id', $attribute->id)->first()) {
                switch ($attribute->type->key) {
                    case 'multiselect':
                        $attributes["attribute_{$attribute->id}"] = json_decode($value->value, true);
                        break;
                    case 'double':
                        $attributes["attribute_{$attribute->id}"] = (double) $value->value;
                        break;
                    case 'integer':
                        $attributes["attribute_{$attribute->id}"] = (integer) $value->value;
                        break;
                    default:
                        $attributes["attribute_{$attribute->id}"] = $value->value;
                }
            }
        }

        $attributes["id"] = $this->id;
        /** */ 
        $attributes["count"] = $this->count;

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
