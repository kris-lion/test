<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(AttributeTypesTableSeeder::class);

        $this->call(UnitGroupsTableSeeder::class);
        $this->call(UnitTypesTableSeeder::class);*/
        $this->call(UnitsTableSeeder::class);
    }
}
