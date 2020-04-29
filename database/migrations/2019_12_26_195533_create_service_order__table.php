<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->string('date')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('paid')->nullable();
            $table->string('amount')->nullable();
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('count')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('technician_id')->nullable();
            $table->foreign('technician_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('service_request')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('service_order');
    }
}
