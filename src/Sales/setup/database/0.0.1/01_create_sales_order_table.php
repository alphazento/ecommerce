<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_no')->unsigned();
            $table->smallInteger('store_id')->unsigned();
            $table->integer('sales_customer_id')->unsigned();
            $table->integer('sales_payment_id')->unsigned();
            $table->integer('sales_billing_address_id')->unsigned();
            $table->integer('sales_shipping_address_id')->unsigned();
            $table->integer('sort_by')->unsigned()->nullable();
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
        Schema::drop('sales_orders');
    }
}