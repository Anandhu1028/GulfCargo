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
        Schema::table('staffs', function (Blueprint $table) {
            $table->string("staff_status",50);
            $table->boolean("visa_status")->default(true)->comment('active:1,inactive:0');
            $table->index('visa_type_id');
            $table->foreignId('visa_type_id')->references('id')->on('visa_types')->onDelete('cascade');
            $table->date("visa_expiry_date")->nullable();
            $table->date("appointment_date")->nullable();
            $table->float("daily_wage");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staffs', function (Blueprint $table) {
            $table->dropColumn('staff_status');
            $table->dropColumn('visa_status');
            $table->dropColumn('visa_type_id');
            $table->dropColumn('visa_expiry_date');
            $table->dropColumn('appointment_date');
            $table->dropColumn('daily_wage');
        });
    }
};
