<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_hour', function (Blueprint $table) {
            $table->increments('id');
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('service_order')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('working_hour');
    }
}
