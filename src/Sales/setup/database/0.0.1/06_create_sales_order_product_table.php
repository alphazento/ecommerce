<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('sku', 255);
            $table->string('name', 255);
            $table->decimal('price', 8, 2);
            $table->decimal('custom_price', 8, 2);
            $table->smallInteger('quantity');
            $table->boolean('shippable');
            $table->boolean('taxable');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('row_price', 8, 2);
            $table->decimal('refund', 8, 2)->default(0);
            $table->string('actuals', 512);
            $table->text('options');
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('sales_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_order_products');
    }
}
