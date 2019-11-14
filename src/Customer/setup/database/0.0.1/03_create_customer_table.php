<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned();
            $table->string('name', 255);
            $table->string('email', 255);//->unique();
            $table->string('email_hash', 32)->index();
            $table->string('password', 255);
            $table->string('remember_token', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_guest')->default(0);
            $table->integer('created_from_portal')->default(0);
            $table->string('prefix', 40)->nullable();
            $table->string('suffix', 40)->nullable();
            $table->date('dob')->nullable();
            $table->integer('default_billing_address_id')->unsigned()->nullable();
            $table->integer('default_shipping_address_id')->unsigned()->nullable();
            $table->string('taxvat', 50)->nullable();
            $table->string('confirmation', 64)->nullable();
            $table->smallInteger('gender')->nullable();
            $table->smallInteger('failures_num')->default(0);
            $table->timestamp('lock_expires')->nullable();
            $table->timestamps();

            // $table->foreign('group_id')
            //     ->references('id')
            //     ->on('customer_groups');

            // $table->foreign('default_billing_address_id')
            //     ->references('id')
            //     ->on('customer_addresses');
            
            // $table->foreign('default_shipping_address_id')
            //     ->references('id')
            //     ->on('customer_addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}