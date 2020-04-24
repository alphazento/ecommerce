<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            //support different customer gorup with different price
            //0 as default group
            $table->integer('customer_group_id')->unsigned()->default(0);
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
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
        Schema::drop('product_prices');
    }
}
