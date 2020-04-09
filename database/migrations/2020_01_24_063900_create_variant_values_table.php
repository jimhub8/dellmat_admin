<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_product_id')->unsigned();
            $table->unsignedBigInteger('product_variant_variant_id')->unsigned();
            $table->unsignedBigInteger('product_option_product_id')->unsigned();
            $table->unsignedBigInteger('option_value_option_id')->unsigned();
            $table->unsignedBigInteger('product_option_id')->unsigned();
            $table->unsignedBigInteger('option_value_id')->unsigned();


            $table->integer('price')->nullable();


            $table->foreign('product_variant_product_id')->references('product_id')->on('product_variants') ->onDelete('cascade');
            $table->foreign('product_variant_variant_id')->references('id')->on('product_variants') ->onDelete('cascade');

            $table->foreign('product_option_product_id')->references('product_id')->on('product_options') ->onDelete('cascade');
            $table->foreign('product_option_id')->references('id')->on('product_options') ->onDelete('cascade');

            $table->foreign('option_value_option_id')->references('option_id')->on('option_values') ->onDelete('cascade');
            $table->foreign('option_value_id')->references('id')->on('option_values') ->onDelete('cascade');
            $table->softDeletes();

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
        Schema::dropIfExists('variant_values');
    }
}
