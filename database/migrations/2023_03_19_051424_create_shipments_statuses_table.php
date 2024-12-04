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
        Schema::create('shipments_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statuses_id')
                ->nullable()
                ->references('id')
                ->on('statuses')
                ->onDelete('cascade')
            ;
            $table->foreignId('shipments_id')
                ->nullable()
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade')
            ;
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
        Schema::dropIfExists('shipments_statuses');
    }
};
