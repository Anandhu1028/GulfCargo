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
        Schema::table('shipment_statuses', function (Blueprint $table) {
            // $table->index("box_id")->nullable()->after('shipments_is');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_statuses', function (Blueprint $table) {
            // $table->dropColumn('box_id');
        });
    }
};
