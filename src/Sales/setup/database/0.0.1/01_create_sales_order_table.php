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
            $table->integer('payment_transaction_id')->unsigned();
            $table->string('order_number', 16);
            $table->boolean('active')->default(1);
            $table->boolean('is_backorder');
            $table->integer('invoice_no')->unsigned();
            $table->smallInteger('store_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('hold_before_status', 32)->nullable();
            $table->boolean('guest_checkout')->default(1);
            $table->boolean('customer_note_notify')->default(1);
            $table->text('customer_note')->nullable();
            $table->string('remote_ip', 45)->nullable();
            $table->boolean('email_sent')->default(0);
            $table->boolean('is_resend_order')->default(0);
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