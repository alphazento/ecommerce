<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_transaction_id')->unsigned();
            $table->string('item_type', 64);
            $table->string('name', 255);
            $table->decimal('quantity', 15, 4)->default(0);
            $table->decimal('price', 15, 4)->default(0);
            $table->string('sku', 255);
            $table->decimal('amount', 15, 4)->default(0);
            $table->decimal('canceled', 15, 4)->default(0);
            $table->decimal('invoiced', 15, 4)->default(0);
            $table->decimal('refunded', 15, 4)->default(0);
            $table->timestamps();

            $table->foreign('payment_transaction_id')
                ->references('id')
                ->on('payment_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_transaction_items');
    }
}