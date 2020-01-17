<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuthPermissions extends Migration
{
    /**
     * Полномочия (Авторизация)
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_permissions', function (Blueprint $table) {
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
        Schema::drop('auth_permissions');
    }
}
