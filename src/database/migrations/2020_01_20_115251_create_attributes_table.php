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
            $table->unsignedBigInteger('category_id')->unsigned()->comment('Идентификатор категории');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('required')->default(false)->comment('Признак обязательного значения');
            $table->string('value')->nullable()->comment('Дополнительное значение');
            $table->boolean('search')->default(false)->comment('Поиск по значению');
            $table->boolean('priority')->default(false)->comment('Приоритетное значение');
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
        Schema::dropIfExists('attributes');
    }
}
