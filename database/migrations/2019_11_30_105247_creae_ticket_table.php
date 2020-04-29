<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaeTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('servicerequest_id')->nullable();
            $table->foreign('servicerequest_id')->references('id')->on('service_request')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('update_by')->nullable();
            $table->foreign('update_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('ticket')->nullable();

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
        Schema::dropIfExists('ticket');
    }
}
