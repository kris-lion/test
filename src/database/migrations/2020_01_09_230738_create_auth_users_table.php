<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthUsersTable extends Migration
{
    /**
     * Пользователи
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('login')->unique()->index()->comment('Логин');
            $table->string('password')->index()->nullable()->comment('Пароль');
            $table->string('remember')->index()->nullable()->comment('Токен');
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
        Schema::drop('auth_users');
    }
}
