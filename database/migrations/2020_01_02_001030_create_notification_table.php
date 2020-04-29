<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message')->nullable();
            $table->longText('link')->nullable();
            $table->longText('icon')->nullable();
            $table->boolean('sells')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('receiver_id')->nullable();
            $table->foreign('receiver_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->softDeletes();
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
        Schema::dropIfExists('notification');
    }
}
