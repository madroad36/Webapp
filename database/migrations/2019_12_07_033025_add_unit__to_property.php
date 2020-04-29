<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitToProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property',function(Blueprint $table){
            $table->string('land_unit')->nullable();
            $table->string('rent_option')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property',function(Blueprint $table){
            $table->dropColumn('land_unit');
            $table->dropColumn('rent_option');


        });
    }
}
