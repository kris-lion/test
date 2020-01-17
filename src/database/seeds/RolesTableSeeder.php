<?php

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        Role::create([
            'name'        => 'user',
            'description' => 'Пользователь'
        ]);

        $role = Role::create([
            'name'        => 'admin',
            'description' => 'Администратор'
        ]);

        $role->permissions()->attach($permissions->pluck('id')->toArray());

        $manager = Role::create([
            'name'        => 'content_manager',
            'description' => 'Контент менеджер'
        ]);

        $manager->permissions()->attach($permissions->whereIn('name', ['reference_category', 'reference'])->pluck('id')->toArray());
    }
}
