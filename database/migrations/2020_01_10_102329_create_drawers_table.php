<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('opening_amount')->nullable();
            $table->decimal('sale_total')->nullable();
            $table->decimal('remaining_amount')->nullable();
            $table->decimal('closing_amount')->nullable();
            $table->decimal('expected_closing_amount')->nullable();
            $table->text('closing_remark')->nullable();
            $table->text('opening_remark')->nullable();
            $table->boolean('open')->default(true);



            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users') ->onDelete('cascade');
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
        Schema::dropIfExists('drawers');
    }
}
