<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('firstname', 255);
            $table->string('middlename', 255)->nullable();
            $table->string('lastname', 255);
            $table->string('company', 128);
            $table->string('address1', 255);
            $table->string('address2', 255);
            $table->string('city', 64);
            $table->string('country', 64);
            $table->string('postal_code', 16);
            $table->string('state', 32);
            $table->string('phone', 32)->nullable();
            $table->smallInteger('address_type');

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
        Schema::drop('shopping_cart_addresses');
    }
}