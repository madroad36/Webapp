<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceToProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property',function(Blueprint $table){
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
        Schema::table('place',function(Blueprint $table){
            $table->dropColumn('place_id');
        });
    }
}
