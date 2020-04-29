<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services',function(Blueprint $table){
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('location')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('place')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service',function(Blueprint $table){
            $table->dropColumn('location_id');
            $table->dropColumn('place_id');
        });
    }
}
