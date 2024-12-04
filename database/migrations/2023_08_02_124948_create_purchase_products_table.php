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
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->id();
            $table->index('purchase_id');
            $table->foreignId('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->string("purchase_number",100);
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
        Schema::dropIfExists('purchase_products');
    }
};
