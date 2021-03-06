<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('sku', 255);
            $table->string('name', 255);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('custom_price', 8, 2);
            $table->smallInteger('quantity');
            // $table->boolean('duplicatable');
            $table->boolean('shippable');
            $table->boolean('taxable');
            $table->decimal('row_price', 8, 2);
            $table->text('options');
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
        Schema::drop('shopping_cart_items');
    }
}
