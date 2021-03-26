<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosationAvillablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posation_avillables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('countary_id');
            $table->softDeletes();
            $table->string('image')->nullable();
            $table->foreign('countary_id')->references('id')->on('countaries')->onDelete('cascade');
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
        Schema::dropIfExists('posation_avillables');
    }
}