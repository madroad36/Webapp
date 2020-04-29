<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAminitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_aminites', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('property')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('aminities_id')->nullable();
            $table->foreign('aminities_id')->references('id')->on('aminites')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
        Schema::dropIfExists('property_aminites');
    }
}
