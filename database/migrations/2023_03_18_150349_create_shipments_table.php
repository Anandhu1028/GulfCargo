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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('status_id')->nullable()
                ->references('id')
                ->on('statuses')
                ->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreignId('receiver_id')->nullable()
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreignId('company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            $table->foreignId('branch_id')
                ->nullable()
                ->references('id')
                ->on('branches')
                ->onDelete('cascade');
            $table->foreignId('prev_branch_id')
                ->nullable()
                ->references('id')
                ->on('branches')
                ->onDelete('cascade');
            $table->foreignId('driver_id')
                ->nullable()
                ->references('id')
                ->on('drivers')
                ->onDelete('cascade');
            $table->foreignId('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreignId('updated_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->date('shiping_date');
            $table->string('receipt_number')->nullable();
            $table->string('packing_type')->nullable();
            $table->string('courier_company')->nullable();
            $table->string('shiping_method')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->integer('number_of_pcs')->nullable();
            $table->float('weight')->nullable();
            $table->float('rate')->nullable();
            $table->float('packing_charge')->nullable();
            $table->float('other_charges')->nullable();
            $table->float('discount')->nullable();
            $table->float('total_amount')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->string('barcode')->nullable();
            $table->string("date", 20)->nullable();
            $table->string('tracking_url', 500)->nullable();
            $table->string('lrl_tracking_code')->nullable();
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
        Schema::dropIfExists('shipments');
    }
};
