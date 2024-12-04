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
        Schema::table("shipments", function (Blueprint $table) {
            $table->integer("origin_id")->after("branch_id")->nullable();
            $table->string("is_transfer")->after("origin_id")->nullable();
            $table->string("transfer_status")->after("is_transfer")->nullable();
            $table->integer("sort_order")->after("id")->nullable();
            $table->integer("shipment_transfer_id")->after("branch_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn('origin_id');
            $table->dropColumn('is_transfer');
            $table->dropColumn('transfer_status');
            $table->dropColumn('sort_order');
            $table->dropColumn('shipment_transfer_id');

        });
    }
};
