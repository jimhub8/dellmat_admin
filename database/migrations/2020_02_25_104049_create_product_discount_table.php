<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('discount_value');
            $table->string('discount_unit');
            $table->string('valid_from')->nullable();
            $table->string('valid_until')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('minimum_order_value')->default(0);
            $table->decimal('maximum_discount_amount')->nullable();
            $table->boolean('is_redeem_allowed')->default(1);

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_discount');
    }
}
