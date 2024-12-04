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
        Schema::table('moving_statuses', function (Blueprint $table) {
            $table->boolean('status')->default(true)->comment('active:1,inactive:0')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moving_statuses', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
