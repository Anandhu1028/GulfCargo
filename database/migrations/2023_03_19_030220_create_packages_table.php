<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')
                ->nullable()
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade')
              ;
            $table->foreignId('branch_id')->nullable()->references('id')
                ->on('branches')->onDelete('cascade');
            $table->text('description');
            $table->integer('quantity');
            $table->float('unit_price');
            $table->float('subtotal');
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
        Schema::dropIfExists('packages');
    }
};
