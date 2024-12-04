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
        Schema::create('salesman', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->index('vehicle_id'); 
            $table->index('driver_id'); 
            $table->foreignId('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade'); 
            $table->foreignId('driver_id')->references('id')->on('drivers')->onDelete('cascade'); 
            $table->string('route', 100)->nullable();
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
        Schema::dropIfExists('salesman');
    }
};
