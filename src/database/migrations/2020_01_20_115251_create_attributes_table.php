<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('Наименование');
            $table->unsignedBigInteger('type_id')->unsigned()->comment('Идентификатор типа');
            $table->foreign('type_id')->references('id')->on('attribute_types')
                ->onUpdate('cascade')->onDelete('cascade');
            //array - тип данных массива
            //list - тип данных текущего узла
            $table->unsignedBigInteger('category_id')->unsigned()->comment('Идентификатор категории');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('attribute_id')->nullable()->unsigned()->comment('Идентификатор атрибута');
            $table->foreign('attribute_id')->references('id')->on('attributes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('size')->nullable();
            $table->boolean('required')->comment('Признак обязательного значения');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
