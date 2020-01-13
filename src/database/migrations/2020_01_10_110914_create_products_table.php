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
            $table->integer('quantity')->nullable()->comment('Количество единиц препарата с учетом фасовки');
            $table->unsignedBigInteger('product_class_id')->nullable()->unsigned()->comment('Идентификатор класса товара');
            $table->foreign('product_class_id')->references('id')->on('product_classes')
                ->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('generic_name_id')->nullable()->unsigned()->comment('Идентификатор международного непатентованного наименования');
            $table->foreign('generic_name_id')->references('id')->on('generic_names')
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('dosage')->nullable()->comment('Дозировка');
            $table->unsignedBigInteger('dosage_form_id')->nullable()->unsigned()->comment('Идентификатор лекарственной формы');
            $table->foreign('dosage_form_id')->references('id')->on('dosage_forms')
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
