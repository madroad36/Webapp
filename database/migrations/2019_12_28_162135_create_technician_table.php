<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service')->nullable();
            $table->string('experience')->nullable();
            $table->string('citizen_no')->nullable();
            $table->string('citizen')->nullable();
            $table->string('certificate')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('category_id')->nullable();

            $table->foreign('category_id')->references('id')->on('service_category')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('technician_id')->nullable();
            $table->foreign('technician_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('technician');
    }
}
