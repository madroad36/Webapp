<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerToProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property',function(Blueprint $table){
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('citizen')->nullable();
            $table->string('owner_image')->nullable();
            $table->string('ammenities')->nullable();

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
            $table->dropColumn('name');
            $table->dropColumn('contact');
            $table->dropColumn('citizen');
            $table->dropColumn('owner_image');
            $table->dropColumn('ammenities');

        });
    }
}
