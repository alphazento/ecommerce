<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    protected function getBuilder() {
        return Schema::getInstance();
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getBuilder()->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->index();
            $table->integer('attribute_set_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned();
            $table->string('path', 255)->index();
            $table->integer('position');
            $table->integer('level')->default(0);
            $table->integer('children_count')->nullable();
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
        $this->getBuilder()->drop('categories');
    }
}