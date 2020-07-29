<?php

namespace App\Models\Category;

use App\Models\Category\Unit\Type;
use App\Models\Category\Unit\Group;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'short', 'group_id', 'type_id'
    ];

    public $timestamps = false;

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
}
