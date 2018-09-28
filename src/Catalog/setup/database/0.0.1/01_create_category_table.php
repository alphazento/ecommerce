<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_set_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->string('path', 255)->index();
            $table->string('hash', 32)->index();
            $table->integer('position');
            $table->integer('level')->default(0);
            $table->integer('children_count');
            $table->boolean('active');
            $table->string('name', 255);
            $table->string('image')->nullable();
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
        Schema::drop('categories');
    }
}