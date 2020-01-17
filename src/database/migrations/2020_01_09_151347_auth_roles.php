<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuthRoles extends Migration
{
    /**
     * Роли (Авторизация)
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_roles', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 32)->unique()->index()->comment('Название');
            $table->string('description')->nullable()->comment('Описание');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auth_roles');
    }
}
