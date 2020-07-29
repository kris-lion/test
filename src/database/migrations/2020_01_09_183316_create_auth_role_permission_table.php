<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthRolePermissionTable extends Migration
{
    /**
     * Полномочия роли
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_role_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->unsigned()->comment('Идентификатор роли');
            $table->foreign('role_id')->references('id')->on('auth_roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('permission_id')->unsigned()->comment('Идентификатор полномочия');
            $table->foreign('permission_id')->references('id')->on('auth_permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_role_permission');
    }
}
