<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatesToService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services',function(Blueprint $table){
            $table->string('rate')->nullable();
            $table->string('rate_type')->nullable();

        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services',function(Blueprint $table){
            $table->dropColumn('rate');
            $table->dropColumn('rate_type');

        });
    }
}
