<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('shipment_status')->unsigned();
            $table->integer('shipping_address_id')->unsigned();
            $table->integer('billing_address_id')->unsigned();
            $table->string('shipping_method', 32)->nullable();
            $table->string('shipping_carrier', 128)->nullable();
            $table->string('shipment_instruction', 255)->nullable();
            $table->decimal('total_weight', 12, 4)->nullable();
            $table->decimal('total_qty', 12, 4)->nullable();
            $table->boolean('can_ship_partially')->default(0);
            $table->smallInteger('can_ship_partially_item')->unsigned()->nullable();
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
        Schema::drop('sales_order_shipments');
    }
}