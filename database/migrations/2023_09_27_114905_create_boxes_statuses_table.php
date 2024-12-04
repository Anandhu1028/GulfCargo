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
        Schema::create('boxes_statuses', function (Blueprint $table) {
            $table->id();
            $table->index('status_id');
            $table->foreignId('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->index('box_id');
            $table->foreignId('box_id')->references('id')->on('boxes')->onDelete('cascade');
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
        Schema::dropIfExists('boxes_statuses');
    }
};
