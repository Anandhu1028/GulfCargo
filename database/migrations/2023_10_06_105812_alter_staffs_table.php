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
        Schema::table("staffs", function (Blueprint $table) {
            $table->integer("document_type_id")->after("visa_type_id")->nullable();
            $table->string("document_number")->after("document_type_id")->nullable();
            $table->string("document_path")->after("document_number")->nullable();
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
            $table->dropColumn('document_type_id');
            $table->dropColumn('document_number');
            $table->dropColumn('document_path');
        });
    }
};
