<?php

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'        => 'role',
            'description' => 'Управление ролями'
        ]);

        Permission::create([
            'name'        => 'user',
            'description' => 'Управление пользователями'
        ]);

        Permission::create([
            'name'        => 'category',
            'description' => 'Управление категориями эталонов'
        ]);

        Permission::create([
            'name'        => 'reference',
            'description' => 'Управление эталонами'
        ]);
    }
}
