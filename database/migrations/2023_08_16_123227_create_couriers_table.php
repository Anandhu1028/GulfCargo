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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string("courier_number",250)->nullable();
            $table->integer("sender_id")->nullable(); 
            $table->integer("source_city")->nullable(); 
            $table->integer("destination_city")->nullable(); 
            $table->integer("branch_id")->nullable(); 
            $table->string("payment_method", 50)->nullable(); 
            $table->dateTime("created_date")->nullable(); 
            $table->string("time", 10)->nullable(); 
            $table->string("collected_by", 20)->nullable(); 
            $table->integer("driver_id")->nullable(); 
            $table->integer("staff_id")->nullable(); 
            $table->dateTime("confirmed_date")->nullable();              
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
        Schema::dropIfExists('couriers');
    }
};
