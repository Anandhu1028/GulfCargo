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
        Schema::create('stock_transfer_products', function (Blueprint $table) {
            $table->id();
            $table->index('stock_id');
            $table->foreignId('stock_id')->references('id')->on('stock_transfers')->onDelete('cascade');
            $table->string("stock_number",100);
            $table->index('product_id');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->float('quantity')->nullable();
            $table->float('amount')->nullable();
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
        Schema::dropIfExists('stock_transfer_products');
    }
};
