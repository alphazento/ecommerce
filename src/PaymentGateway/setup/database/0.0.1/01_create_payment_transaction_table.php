<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->default(0);  //order id
            $table->string('pay_id', 32)->unique(); //payment_method + payment id hash
            $table->string('ext_transaction_id', 255);     //3rd party payment id from method vendor
            $table->string('payment_method', 32);
            $table->string('status', 64);
            $table->integer('customer_id')->unsigned();
            $table->string('customer_email', 255)->nullable();
            $table->text('quote')->nullable();
            $table->string('currency', 8);
            $table->decimal('subtotal', 15, 4)->default(0);
            $table->decimal('shipping', 15, 4)->default(0);
            $table->decimal('total', 15, 4)->default(0);

            $table->decimal('amount_due', 15, 4)->default(0);
            $table->decimal('amount_authorized', 15, 4)->default(0);
            $table->decimal('amount_paid', 15, 4)->default(0);
            $table->decimal('amount_refunded', 15, 4)->default(0);
            $table->decimal('amount_canceled', 15, 4)->default(0);
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
        Schema::drop('payment_transactions');
    }
}