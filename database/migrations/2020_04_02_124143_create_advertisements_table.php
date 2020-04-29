<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('slug');
          $table->bigInteger('contact');
          $table->string('image');
          $table->date('start_date')->nullable();
          $table->date('end_date')->nullable();
          $table->bigInteger('price')->nullable();
          $table->integer('index')->unique();
          $table->boolean('status')->default(0);
          $table->unsignedInteger('created_by');
          $table->foreign('created_by')
          ->references('id')
          ->on('users')
          ->onUpdate('RESTRICT')
          ->onDelete('cascade');
          $table->rememberToken();
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
        Schema::dropIfExists('advertisements');
    }
}
