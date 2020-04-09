<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_no');
            $table->decimal('amount');
            $table->string('status')->default('pedding');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('admin_id')->references('id')->on('admins') ->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers') ->onDelete('cascade');
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
        Schema::dropIfExists('withdraws');
    }
}
