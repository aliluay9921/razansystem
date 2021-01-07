<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_flights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('flightline_id');
            $table->softDeletes();
            $table->string('details');
            $table->integer('code_discount')->nullable();
            $table->integer('discount');
            $table->integer('miximum_number');
            $table->integer('minimum_number');
            $table->integer('current_user');
            $table->date('expair');
            $table->date('fromdate');
            $table->integer('active')->default(1);
            $table->date('returndate');
            $table->integer('type');
            $table->string('from');
            $table->string('to');

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
        Schema::dropIfExists('discount_flights');
    }
}
