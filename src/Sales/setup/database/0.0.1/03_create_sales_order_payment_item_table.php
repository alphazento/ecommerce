<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderPaymentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->unsigned();
            $table->string('item_type');
            $table->decimal('amount', 15, 4)->default(0);
            $table->decimal('canceled', 15, 4)->default(0);
            $table->decimal('invoiced', 15, 4)->default(0);
            $table->decimal('refunded', 15, 4)->default(0);
            $table->decimal('tax_amount', 15, 4)->default(0);
            $table->decimal('tax_refunded', 15, 4)->default(0);
            $table->decimal('tax_canceled', 15, 4)->default(0);
            $table->decimal('tax_invoiced', 15, 4)->default(0);
            $table->timestamps();

            $table->foreign('payment_id')
                ->references('id')
                ->on('sales_order_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_order_payment_items');
    }
}