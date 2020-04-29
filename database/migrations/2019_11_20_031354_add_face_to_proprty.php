<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFaceToProprty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property',function(Blueprint $table){
            $table->string('face')->nullable();
            $table->string('shape')->nullable();
            $table->string('road_size')->nullable();
            $table->string('direction')->nullable();
            $table->boolean('parking')->nullable()->default(0);
            $table->string('house_type')->nullable();
            $table->string('drainage')->nullable();
            $table->string('build')->nullable();
            $table->string('total_room')->nullable();
            $table->string('kitchen')->nullable();
            $table->string('store')->nullable();
            $table->string('bathroom')->nullable();
            $table->string('living_room')->nullable();
            $table->string('hall')->nullable();








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
            $table->dropColumn('face');
            $table->dropColumn('shape');
            $table->dropColumn('road_size');
            $table->dropColumn('direction');
            $table->dropColumn('parking');
            $table->dropColumn('house_type');
            $table->dropColumn('drainage');
            $table->dropColumn('build');
            $table->dropColumn('total_room');
            $table->dropColumn('kitchen');
            $table->dropColumn('store');
            $table->dropColumn('bathroom');
            $table->dropColumn('living_room');
            $table->dropColumn('hall');



        });
    }
}
