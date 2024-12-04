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
        Schema::create('tripsheets', function (Blueprint $table) {
            $table->id();
            $table->integer("tripsheet_no")->nullable();
            $table->integer("branch_id")->nullable(); 
            $table->date("trip_date")->nullable();
            $table->string("trip_time")->nullable();
            $table->date("estimate_arrival_date")->nullable();
            $table->integer("agency_id")->nullable();
            $table->string("vehicle_id")->nullable();
            $table->string("driver_name")->nullable();
            $table->string("driver_mobile")->nullable();
            $table->string("hepler_name")->nullable();
            $table->string("helper_mobile")->nullable();
            $table->string("start_km")->nullable();
            $table->string("stop_km")->nullable();
            $table->string("total_km")->nullable();
            $table->string("total_rent")->nullable();
            $table->string("destination")->nullable();
            $table->string("diesel_amt")->nullable();
            $table->string("batha_amt")->nullable();
            $table->string("phone_exp")->nullable();
            $table->string("toll_expense")->nullable();
            $table->string("food_amt")->nullable();
            $table->string("other_exp")->nullable();
            $table->string("expense_total")->nullable();
            $table->string("advance_amt")->nullable();
            $table->string("balance_amount")->nullable();
            $table->string("status")->nullable();  
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
        Schema::dropIfExists('tripsheets');
    }
};
