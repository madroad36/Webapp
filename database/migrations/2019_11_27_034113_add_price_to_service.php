<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceToService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services',function(Blueprint $table){
            $table->string('task')->nullable();
            $table->string('monthly')->nullable();
            $table->string('yearly')->nullable();
            $table->string('member')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services',function(Blueprint $table){
            $table->dropColumn('task');
            $table->dropColumn('monthly');
            $table->dropColumn('yearly');
            $table->dropColumn('member');

        });
    }
}
