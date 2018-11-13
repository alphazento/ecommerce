<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guid', 36)->unique();
            $table->string('email', 255);
            $table->string('customer_id', 255);
            $table->string('store_id', 255);
            $table->string('mode', 32);
            $table->string('currency', 16);
            $table->string('applied_rule_ids', 128);
            $table->string('client_ip', 48);
            $table->tinyInteger('status');  // inprogress, abandoned, converted
            $table->boolean('ship_to_billingaddesss');
            $table->integer('billing_address_id')->unsigned();
            $table->integer('shipping_address_id')->unsigned();
            $table->integer('invoice_number')->unsigned();
            $table->smallInteger('payment_method')->unsigned();
            $table->integer('total_weight')->unsigned();

            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('grand_total', 8, 2)->default(0);
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('handle_fee', 8, 2)->default(0);
            $table->decimal('subtotal', 8, 2)->unsigned();
            $table->decimal('subtotal_with_discount', 8, 2)->unsigned();
            $table->decimal('total', 8, 2)->unsigned();
            $table->string('comment', 255)->nullable();
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
        Schema::drop('shopping_carts');
    }
}