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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->index('sale_id');
            $table->foreignId('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->string("sale_number",100);
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
        Schema::dropIfExists('sale_products');
    }
};
