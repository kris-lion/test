<?php

use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();

        $admin = User::create([
            'login'    => 'admin',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach($roles->whereIn('name', ['user', 'admin'])->pluck('id')->toArray());

        $manager = User::create([
            'login'    => 'manager',
            'password' => Hash::make('password')
        ]);

        $manager->roles()->attach($roles->whereIn('name', ['user', 'content_manager'])->pluck('id')->toArray());
    }
}
