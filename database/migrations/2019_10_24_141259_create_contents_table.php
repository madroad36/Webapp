<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable()->default(null);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('display_in')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->text('short_desc')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->integer('display_order')->nullable()->default(null);
            $table->boolean('is_active')->default(0);
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('contents')->onDelete('cascade');
            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
