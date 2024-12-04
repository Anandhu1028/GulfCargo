<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moving_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name",250)->nullable();
            $table->string("slug",250)->nullable(); 
            $table->timestamps(); 

        });

         // Insert some stuff
            DB::table('moving_statuses')->insert(
                array(
                    [
                        'name' => 'Enquiry Collected',
                        'slug' => 'enquiry-collected'
                    ],
                    [
                        'name' => 'Confirmed by customer',
                        'slug' => 'confirmed-by-customer'
                    ],
                    [
                        'name' => 'Rejected',
                        'slug' => 'rejected'
                    ],
                    [
                        'name' => 'Pending',
                        'slug' => 'pending'
                    ],
                )
            );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moving_statuses');
    }
};
