<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSellsRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sells_record', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('buyer_id')->nullable();
            $table->foreign('buyer_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('product')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->string('quantity');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sells_record');
    }
}
