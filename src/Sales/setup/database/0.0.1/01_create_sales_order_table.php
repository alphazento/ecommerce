<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('store_id')->unsigned();
            $table->string('order_number', 16);
            $table->integer('invoice_id')->unsigned()->default(0);
            $table->integer('status_id')->unsigned();
            $table->integer('hold_before_status_id')->unsigned()->default(0);
            $table->integer('amend_from')->unsigned()->default(0); //when customer need to amend order, origin order set active = 0
            $table->integer('resend_from')->unsigned()->default(0); //when resend all or partial order items from origin order. still set active=1
            $table->boolean('is_backorder')->default(0);
            $table->integer('customer_id')->unsigned();
            $table->string('customer_note', 255)->nullable();
            $table->boolean('is_guest')->default(1);
            $table->string('remote_ip', 45)->nullable();
            $table->boolean('active')->default(1);
            $table->decimal('subtotal', 8, 2)->unsigned()->default(0);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
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
