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
        Schema::create('statuses_booking_numbers', function (Blueprint $table) {
            $table->id();
            $table->index('status_id');
            $table->foreignId('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->index('booking_id');
            $table->foreignId('booking_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses_booking_numbers');
    }
};
