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
        Schema::table("shipments",function (Blueprint $table){
            //  $table->float('total_weight')->nullable();
            //  $table->float('msic_weight')->nullable();
            //  $table->float('grand_total_box_value')->nullable();
            //  $table->float('total_freight')->nullable();
            //  $table->float('misc_freight')->nullable();
            //  $table->float('document_charge')->nullable();
            //  $table->float('grand_total')->nullable();
            //  $table->float('package_total_amount')->nullable();
            //  $table->float('package_total_quantity')->nullable();
        });   

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function($table) {
            // $table->dropColumn('total_weight');  
            // $table->dropColumn('msic_weight');  
            // $table->dropColumn('grand_total_box_value');  
            // $table->dropColumn('total_freight');  
            // $table->dropColumn('misc_freight');  
            // $table->dropColumn('document_charge');  
            // $table->dropColumn('grand_total');  
            // $table->dropColumn('package_total_amount');  
            // $table->dropColumn('package_total_quantity');  
            
        });
    }
};
