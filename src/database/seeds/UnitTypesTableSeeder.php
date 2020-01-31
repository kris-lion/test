<?php

use App\Models\Category\Unit\Type;
use Illuminate\Database\Seeder;

class UnitTypesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['name' => 'Международные единицы измерения, включенные в ЕСКК']);
        Type::create(['name' => 'Национальные единицы измерения, включенные в ЕСКК']);
        Type::create(['name' => 'Международные единицы измерения, не включенные в ЕСКК']);
    }
}
