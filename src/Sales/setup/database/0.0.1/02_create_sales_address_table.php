<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('company', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address1', 255);
            $table->string('address2', 255)->nullable();
            $table->string('city', 64);
            $table->string('country', 64);
            $table->string('postal_code', 16);
            $table->string('state', 32);
            $table->string('phone', 32)->nullable();
            $table->string('hash', 32)->unique();
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
        Schema::drop('sales_addresses');
    }
}
