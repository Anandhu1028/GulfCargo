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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->nullable()
                ->references('id')
                ->on('customers')
                ->onDelete('cascade')
               ;
            $table->foreignId('country_id')
                ->nullable()
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
               ;
            $table->foreignId('state_id')
                ->nullable()
                ->references('id')
                ->on('states')
                ->onDelete('cascade')
               ;
            $table->integer('zip_code')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('customer_addresses');
    }
};
