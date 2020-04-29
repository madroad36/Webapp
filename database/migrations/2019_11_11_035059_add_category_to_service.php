<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services',function(Blueprint $table){
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('service_category')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
            $table->dropColumn('category_id');
        });
    }
}
