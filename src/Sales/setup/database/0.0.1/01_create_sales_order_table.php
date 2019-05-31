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
            $table->string('order_number', 16);
            $table->integer('invoice_no')->unsigned();
            $table->smallInteger('store_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->string('hold_before_status', 32)->nullable();
            $table->string('coupon_code', 255)->nullable();
            $table->integer('customer_id')->unsigned();
            $table->boolean('customer_is_guest')->default(1);
            $table->integer('ext_customer_id')->nullable();
            $table->integer('ext_order_id')->nullable();
            $table->boolean('customer_note_notify')->default(1);
            $table->text('customer_note')->nullable();
            $table->string('applied_rule_ids', 128)->nullable();
            $table->string('remote_ip', 45)->nullable();
            $table->decimal('total_item_count', 12, 4)->default(0);
            $table->integer('cart_address_id')->unsigned();
            $table->integer('cart_id')->unsigned();
            $table->boolean('email_sent')->default(0);
            $table->boolean('is_resend_order')->default(0);
            $table->decimal('total_amount_include_tax')->default(0);
            $table->string('base_currency_code')->default(0);
            $table->string('order_currency_code')->default(0);
            $table->string('base_to_order_currency_rate')->default(0);
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