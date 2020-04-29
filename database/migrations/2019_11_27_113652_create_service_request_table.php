<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('technician_id')->nullable();
            $table->foreign('technician_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('order_by')->nullable();
            $table->foreign('order_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->boolean('hourly')->nullable()->default(0);
            $table->boolean('task')->nullable()->default(0);
            $table->boolean('member')->nullable()->default(0);
            $table->boolean('yearly')->nullable()->default(0);
            $table->boolean('monthly')->nullable()->default(0);
            $table->boolean('paid')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('location_id')->nullable();
            $table->string('totalamount')->nullable();
            $table->foreign('location_id')->references('id')->on('location')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('place_id')->nullable();
            $table->foreign('place_id')->references('id')->on('place')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('service_request');
    }
}
