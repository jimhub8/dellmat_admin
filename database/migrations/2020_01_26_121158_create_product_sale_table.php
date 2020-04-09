<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sku_no');
            $table->string('status')->default('Pending');

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sku_id');
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('seller_id');

            $table->foreign('sku_id')->references('id')->on('skus') ->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales') ->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products') ->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers') ->onDelete('cascade');
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
        Schema::dropIfExists('product_sale');
    }
}
