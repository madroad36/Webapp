<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broker', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service')->nullable();
            $table->string('experience')->nullable();
            $table->string('citizen_no')->nullable();
            $table->string('citizen')->nullable();
            $table->string('certificate')->nullable();
            $table->unsignedInteger('broker_id')->nullable();
            $table->foreign('broker_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('broker');
    }
}
