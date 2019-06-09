<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('payment_method', 128)->nullable();
            $table->string('payment_transaction_id', 128)->nullable();
            $table->text('comment')->nullable();
            $table->decimal('amount_due', 12, 4)->default(0);
            $table->decimal('amount_authorized', 12, 4)->default(0);
            $table->decimal('amount_paid', 12, 4)->default(0);
            $table->decimal('amount_refunded', 12, 4)->default(0);
            $table->decimal('amount_canceled', 12, 4)->default(0);
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
        Schema::drop('sales_order_payments');
    }
}
