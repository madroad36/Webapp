<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToserviceRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_request',function(Blueprint $table){
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->string('pereffered_date')->nullable();
            $table->longText('description')->nullable();

        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_request',function(Blueprint $table){
            $table->dropColumn('location');
            $table->dropColumn('contact');
            $table->dropColumn('pereffered_date');
            $table->dropColumn('description');

        });
    }
}
