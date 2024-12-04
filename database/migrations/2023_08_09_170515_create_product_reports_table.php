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
        Schema::create('product_reports', function (Blueprint $table) {
            $table->id();
            $table->date("transaction_date");
            $table->string('transaction_type',100);
            $table->string('transaction_id',50);
            $table->index('branch_id');
            $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->index('product_id');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('quantity',20)->nullable();
            $table->float('amount')->nullable();
            $table->string('opening_stock',20);
            $table->string('closing_stock',20);
            $table->string('UOM',10);
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
        Schema::dropIfExists('product_report');
    }
};
