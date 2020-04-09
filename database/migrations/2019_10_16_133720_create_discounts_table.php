<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('offername')->nullable();
            $table->decimal('toprice')->nullable();
            $table->string('type')->nullable();
            $table->decimal('value')->nullable();
            $table->string('converted_fromprice')->nullable();
            $table->decimal('converted_toprice')->nullable();
            $table->decimal('converted_value')->nullable();
            $table->decimal('ffromprice')->nullable();
            $table->decimal('fromprice')->nullable();
            $table->decimal('ftoprice')->nullable();
            $table->decimal('fvalue')->nullable();
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
        Schema::dropIfExists('discounts');
    }
}
