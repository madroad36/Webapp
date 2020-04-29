<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrokerToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::table('users',function(Blueprint $table){
        $table->boolean('broker')->default(0);
        $table->boolean('vendor')->default(0);
        $table->boolean('service')->default(0);

    });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('broker');
            $table->dropColumn('vendor');
            $table->dropColumn('service');

        });//
    }
}
