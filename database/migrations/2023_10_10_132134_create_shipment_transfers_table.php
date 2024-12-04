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
        Schema::create('shipment_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer("shipment_id")->nullable(); 
            $table->string("booking_number")->nullable();
            $table->integer("transfer_from")->nullable();
            $table->integer("transfer_to")->nullable();   
            $table->string("transferred_status")->nullable();
            $table->integer("driver_id")->nullable();
            $table->string("comments")->nullable();
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
        Schema::dropIfExists('shipment_transfers');
    }
};
