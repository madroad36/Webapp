<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeToServiceRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_request',function(Blueprint $table){
            $table->string('duration')->nullable();
            $table->string('count')->nullable();

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
            $table->dropColumn('duration');
            $table->dropColumn('count');

        });
    }
}
