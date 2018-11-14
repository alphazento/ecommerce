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
            $table->string('email', 255)->nullable();
            $table->integer('store_id')->unsigned()->default(0);
            $table->integer('customer_id')->unsigned();
            $table->string('guest_guid', 36)->nullable();
            $table->tinyInteger('mode')->default(0); //0:guest, 1:customer, 2:admin
            $table->string('currency', 16)->default('USD');
            $table->string('applied_rules', 255)->nullable();
            $table->string('coupon_codes', 255)->nullable();
            $table->string('client_ip', 48)->nullable();
            $table->tinyInteger('status')->default(0);  // 0:inprogress, 1:abandoned, 2:converted
            $table->boolean('ship_to_billingaddesss')->default(0);
            $table->integer('billing_address_id')->unsigned()->default(0);
            $table->integer('shipping_address_id')->unsigned()->default(0);
            $table->integer('order_id')->unsigned()->default(0);
            $table->decimal('total_weight', 8, 2)->unsigned()->default(0);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('grand_total', 8, 2)->default(0);
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('handle_fee', 8, 2)->default(0);
            $table->decimal('subtotal', 8, 2)->unsigned()->default(0);
            $table->decimal('subtotal_with_discount', 8, 2)->unsigned()->default(0);
            $table->decimal('total', 8, 2)->unsigned()->default(0);
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