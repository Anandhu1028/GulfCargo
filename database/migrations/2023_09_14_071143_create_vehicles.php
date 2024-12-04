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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->date('reg_date');  
            $table->date('reg_expiry');
            $table->date('next_passing')->nullable();
            $table->date('sticker_permission_expiry')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->string('traffic_no',150)->nullable();
            $table->date('gps_permit_expiry',150)->nullable();
            $table->string('vehicle_no',150);
            $table->string('status',150)->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
