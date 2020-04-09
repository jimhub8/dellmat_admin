<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storedetails', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('address_2')->nullable();
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_website')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('business_no')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('logo')->nullable();
            $table->text('location')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();

            $table->string('payment_mode')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_name')->nullable();

            $table->string('mpesa_reg_name')->nullable();
            $table->string('mpesa_phone')->nullable();

            $table->unsignedBigInteger('seller_id');
            // $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
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
        Schema::dropIfExists('storedetails');
    }
}
