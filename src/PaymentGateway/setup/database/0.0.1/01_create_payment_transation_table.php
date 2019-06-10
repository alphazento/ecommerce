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
            $table->string('payment_method', 32);
            $table->string('ref_id', 255);              //payment id from method vendor
            $table->string('ref_id_hash', 32)->index(); //payment id hash
            $table->boolean('success');           //payment status from method vendor
            $table->integer('customer_id')->unsign();
            $table->decimal('amount_due', 15, 4)->default(0);
            $table->decimal('amount_authorized', 15, 4)->default(0);
            $table->decimal('amount_paid', 15, 4)->default(0);
            $table->decimal('amount_refunded', 15, 4)->default(0);
            $table->decimal('amount_canceled', 15, 4)->default(0);
            $table->text('raw_response');
            $table->text('comment');
            $table->timestamps();
            $table->unique(['payment_method', 'ref_id_hash']);
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