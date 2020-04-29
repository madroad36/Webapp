<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product',function(Blueprint $table){
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product',function(Blueprint $table){
            $table->dropColumn('quantity');
            $table->dropColumn('unit');


        });
    }
}
