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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->date("stock_date");
            $table->string("stock_number",100);
            $table->index('branch_id_from');
            $table->foreignId('branch_id_from')->references('id')->on('branches')->onDelete('cascade');
            $table->index('branch_id_to');
            $table->foreignId('branch_id_to')->references('id')->on('branches')->onDelete('cascade');
            $table->float('total_amount')->nullable();
            $table->string('total_quantity',100)->nullable();
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
        Schema::dropIfExists('stock_transfers');
    }
};
