<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Наименование');
            $table->string('short')->nullable()->comment('Сокращение');
            $table->string('code')->comment('Код');
            $table->unsignedBigInteger('group_id')->unsigned()->comment('Идентификатор группы');
            $table->foreign('group_id')->references('id')->on('unit_groups')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('type_id')->unsigned()->comment('Идентификатор типа');
            $table->foreign('type_id')->references('id')->on('unit_types')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
