<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->integer('fuel_capacity')->unsigned();
            $table->integer('fuel_level');
            $table->integer('weight_capacity')->unsigned();
            $table->string('location_planet');
            $table->timestamps();
        
            $table->foreign('pilot_id')->references('id')->on('pilots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ships');
    }
};