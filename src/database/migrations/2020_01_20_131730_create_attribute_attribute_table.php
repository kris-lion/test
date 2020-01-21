<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_attribute', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id')->unsigned()->comment('Идентификатор атрибута');
            $table->foreign('attribute_id')->references('id')->on('attributes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('object_id')->unsigned()->comment('Идентификатор объекта');
            $table->foreign('object_id')->references('id')->on('attributes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['attribute_id', 'object_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_attribute');
    }
}
