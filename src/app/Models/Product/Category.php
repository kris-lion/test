<?php

namespace App\Models\Product;

use App\Models\Product\Category\Group;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'group_id'
    ];

    public $timestamps = false;

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
