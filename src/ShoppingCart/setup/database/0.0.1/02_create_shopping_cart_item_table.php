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
            $table->string('name', 255);
            $table->string('sku', 255);
            $table->decimal('price', 8, 2);
            $table->decimal('custom_price', 8, 2);
            $table->text('description');
            $table->string('url', 255);
            $table->string('image', 255);
            $table->smallInteger('quantity');
            $table->smallInteger('minQuantity');
            $table->smallInteger('maxQuantity');
            $table->boolean('shippable');
            $table->boolean('taxable');
            $table->decimal('tax_amount', 8, 2);
            $table->boolean('duplicatable');
            $table->decimal('unitPrice', 8, 2);
            $table->decimal('totalPrice', 8, 2);
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