<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('name', 255)->index();
            $table->integer('attribute_set_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned();
            $table->string('path', 255)->index();
            $table->integer('position');
            $table->integer('level')->default(0);
            $table->integer('children_count')->nullable()->default(0);
            $table->boolean('active');
            $table->integer('sort_by')->unsigned()->nullable();
            $table->timestamps();
            $table->unique(['parent_id', 'name']);
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
