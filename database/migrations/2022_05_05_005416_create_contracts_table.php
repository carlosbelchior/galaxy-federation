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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pilot_id')->unsigned();
            $table->bigInteger('ship_id')->unsigned();
            $table->string('description');
            $table->bigInteger('payload')->unsigned();
            $table->string('origin_planet');
            $table->string('destination_planet');
            $table->bigInteger('value')->unsigned();
            $table->integer('status_complete')->default(0);
            $table->integer('accepted')->default(0);
            $table->timestamps();

            $table->foreign('pilot_id')->references('id')->on('pilots');
            $table->foreign('ship_id')->references('id')->on('ships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
