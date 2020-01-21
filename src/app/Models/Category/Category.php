<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }
}
