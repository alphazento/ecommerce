<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('name', 255);
            $table->string('sku', 255);
            $table->decimal('price', 8, 2);
            $table->decimal('custom_price', 8, 2);
            $table->text('description');
            $table->string('url', 255);
            $table->string('image', 255);
            $table->smallInteger('quantity');
            $table->smallInteger('min_quantity');
            $table->smallInteger('max_quantity');
            $table->boolean('duplicatable');
            $table->boolean('shippable');
            $table->boolean('taxable');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
            // 'taxes',//  []
            // 'options'
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shopping_cart_items');
    }
}