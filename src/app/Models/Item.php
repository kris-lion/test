<?php

namespace App\Models;

use App\Models\Category\Attribute\Value;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'category_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, 'item_id', 'id');
    }
}
