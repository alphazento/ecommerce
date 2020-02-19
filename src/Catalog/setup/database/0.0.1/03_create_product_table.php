<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
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
        $this->getBuilder()->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_set_id')->unsigned();
            $table->string('sku', 255);
            $table->string('name', 255);
            $table->string('type_id', 64);
            $table->boolean('has_options');
            $table->boolean('required_options');
            $table->boolean('active');
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
        $this->getBuilder()->drop('products');
    }
}