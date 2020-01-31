<?php

namespace App\Models;

use App\Models\Category\Attribute\Value;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

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
