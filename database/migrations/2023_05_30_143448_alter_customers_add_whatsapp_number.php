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
        

        
    
        
        Schema::table("customers",function (Blueprint $table){
            // $table->string('country_code_phone','10')->after('email');
            // $table->string('country_code_whatsapp','15')->after('phone');
            // $table->string('whatsapp_number','10')->after('country_code_whatsapp');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function($table) {
            // $table->dropColumn('country_code_phone');
            // $table->dropColumn('country_code_whatsapp');
            // $table->dropColumn('whatsapp_number');
        });
    }
};
