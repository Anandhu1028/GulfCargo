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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->references('id')
                ->on('branches')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')
                ->nullable()
                ->references('id')

                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
};
