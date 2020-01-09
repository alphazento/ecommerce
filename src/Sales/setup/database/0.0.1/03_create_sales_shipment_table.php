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
            $table->integer('sales_address_id')->unsigned();
            $table->integer('shipping_carrier_id')->unsigned()->nullable();
            $table->integer('shipping_method_id')->unsigned()->nullable();
            $table->integer('shipment_status_id')->unsigned();
            $table->string('shipment_instruction', 255)->nullable();
            $table->decimal('total_weight', 12, 4)->nullable();
            $table->decimal('total_qty', 12, 4)->nullable();
            $table->boolean('can_ship_partially')->default(0);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('sales_orders');
            
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
            
            $table->foreign('sales_address_id')
                ->references('id')
                ->on('sales_addresses');
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