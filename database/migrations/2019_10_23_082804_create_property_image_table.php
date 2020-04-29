<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_image', function (Blueprint $table) {
            $table->increments('id');

            $table->string('image');
            $table->unsignedInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('property')->onUpdate('RESTRICT')->onDelete('CASCADE');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_image');
    }
}
