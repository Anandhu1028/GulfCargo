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
        // Schema::create('ships', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('shipment_id');
        //     $table->index('branch_id');
        //     $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
        //     $table->string('shipment_name');
        //     $table->string('awd_id');
        //     $table->string('tracking_url');
        //     $table->datetime('created_date');
        //     $table->string('shipment_status');
        //     $table->datetime('estimated_delivery');
        //     $table->index('shipment_status');
        //     $table->index('shipment_status');
        //     $table->index('port_of_origin_id');
        //     $table->foreignId('port_of_origin_id')->references('id')->on('port_of_origins')->onDelete('cascade');
        //     $table->index('shipment_type_id');
        //     $table->foreignId('shipment_type_id')->references('id')->on('shipment_types')->onDelete('cascade');
        //     $table->index('clearing_agent_id');
        //     $table->foreignId('clearing_agent_id')->references('id')->on('clearing_agents')->onDelete('cascade');
        //     $table->index('status_id');
        //     $table->foreignId('status_id')->references('id')->on('statuses')->onDelete('cascade');
        //     $table->string("awb_number");
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ships', function (Blueprint $table) {
        //     // $table->dropColumn('port_of_origin_id');
        //     // $table->dropColumn('shipment_type_id');
        //     // $table->dropColumn('clearing_agent_id');
        //     // $table->dropColumn('awb_number');

        // });
    }
};
