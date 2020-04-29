<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('thumbnail');
            $table->longText('description');
            $table->string('plot_no')->nullable()->default(0);
            $table->longText('overview');
            $table->string('price');
            $table->string('feature');
            $table->string('broker')->nullable()->default(0);
            $table->string('near_by');
            $table->string('service_charge')->nullable()->default(0);
            $table->string('review')->nullable()->default(0);
            $table->unsignedInteger('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('area')->nullable()->default(0);
            $table->string('sold')->nullable()->default(0);
            $table->string('paid')->nullable()->default(0);
            $table->string('property_image')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('location')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('category')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('broker_id')->nullable();
            $table->foreign('broker_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');

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
        Schema::dropIfExists('property');
    }
}
