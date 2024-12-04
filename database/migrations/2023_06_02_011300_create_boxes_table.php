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
        // Schema::create('boxes', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('shipment_id')->nullable()->references('id')
        //         ->on('shipments')->onDelete('cascade');              
        //     $table->float('length')->nullable();
        //     $table->float('width')->nullable();
        //     $table->float('height')->nullable();
        //     $table->float('weight')->nullable();
        //     $table->float('unit_value')->nullable();
        //     $table->float('total_value')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('boxes');
    }
};
