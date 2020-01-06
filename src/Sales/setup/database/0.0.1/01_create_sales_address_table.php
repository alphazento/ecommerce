<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            // $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
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