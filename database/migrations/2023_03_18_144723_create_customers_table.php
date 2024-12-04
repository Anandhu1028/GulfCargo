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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreignId('branch_id')->references('id')
                ->on('branches')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 13);
            $table->enum('type', ['sender', 'receiver']);
            $table->string('identification_type')->nullable();
            $table->string('identification_number')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
               ;
            $table->foreignId('updated_by')
                ->nullable()
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('customers');
    }
};
