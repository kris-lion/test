<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuthUserRole extends Migration
{
    /**
     * Роли пользователя
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_user_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unsigned()->comment('Идентификатор пользователя');
            $table->foreign('user_id')->references('id')->on('auth_users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('role_id')->unsigned()->comment('Идентификатор роли');
            $table->foreign('role_id')->references('id')->on('auth_roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_user_role');
    }
}
