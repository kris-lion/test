<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('standard')->comment('Эталонное наименование');
            $table->string('name')->nullable()->comment('Имя');
            $table->string('dosage_short')->nullable()->comment('Дозировка краткая / за 1 единицу');
            $table->integer('packing')->nullable()->comment('Фасовка');
            $table->string('addition')->nullable()->comment('Дополнение после фасовки');
            $table->double('volume')->nullable()->comment('Объем, вес и дозы');
            $table->unsignedBigInteger('unit_id')->nullable()->unsigned()->comment('Идентификатор единицы измерения');
            $table->foreign('unit_id')->references('id')->on('units')
                ->onUpdate('cascade')->onDelete('set null');
            $table->integer('quantity')->nullable()->comment('Количество единиц с учетом фасовки');
            $table->unsignedBigInteger('category_id')->nullable()->unsigned()->comment('Идентификатор категории (класса) товара');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('generic_id')->nullable()->unsigned()->comment('Идентификатор международного непатентованного наименования');
            $table->foreign('generic_id')->references('id')->on('generics')
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('dosage')->nullable()->comment('Дозировка');
            $table->unsignedBigInteger('form_id')->nullable()->unsigned()->comment('Идентификатор формы');
            $table->foreign('form_id')->references('id')->on('forms')
                ->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('products');
    }
}
