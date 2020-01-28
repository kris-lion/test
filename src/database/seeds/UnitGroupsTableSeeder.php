<?php

use App\Models\Category\Unit\Group;
use Illuminate\Database\Seeder;

class UnitGroupsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Group::create(['name' => 'Единицы длины']);
        Group::create(['name' => 'Единицы площади']);
        Group::create(['name' => 'Единицы объема']);
        Group::create(['name' => 'Единицы массы']);
        Group::create(['name' => 'Технические единицы']);
        Group::create(['name' => 'Единицы времени']);
        Group::create(['name' => 'Экономические единицы']);
    }
}
