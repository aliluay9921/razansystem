<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('from');
            $table->uuid('user_id');
            $table->uuid('to');
            $table->integer('cabin');
            $table->integer('active')->nullable()->default(0);
            $table->integer('expired')->nullable()->default(0);
            $table->date('fromdate')->nullable();
            $table->date('returndate')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
