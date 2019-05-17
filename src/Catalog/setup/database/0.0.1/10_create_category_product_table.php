<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryProductTable extends Migration
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
        $this->getBuilder()->create('category_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->boolean('direct_relation')->default(0);
            $table->integer('position');
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
        $this->getBuilder()->drop('category_products');
    }
}