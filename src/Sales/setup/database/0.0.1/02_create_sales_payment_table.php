<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_no')->unsigned();
            $table->smallInteger('store_id')->unsigned();
            $table->integer('sales_customer_id')->unsigned();
            $table->integer('sales_billing_address_id')->unsigned();
            $table->integer('sales_shipping_address_id')->unsigned();
            $table->integer('children_count');
            $table->string('firstname', 32)->nullable();
            $table->string('middlename', 32)->nullable();
            $table->string('lastname', 32)->nullable();
            $table->string('company', 40)->nullable();
            $table->string('payment_method', 128)->nullable();
            $table->string('payment_code', 128)->nullable();
            $table->text('comment')->nullable();


// | affiliate_id            | int(11)       | NO   |     | NULL       |                |
// | commission              | decimal(15,4) | NO   |     | NULL       |                |
// | marketing_id            | int(11)       | NO   |     | NULL       |                |
// | tracking                | varchar(64)   | NO   |     | NULL       |                |
// | language_id             | int(11)       | NO   |     | NULL       |                |
// | currency_id             | int(11)       | NO   |     | NULL       |                |
// | currency_code           | varchar(3)    | NO   |     | NULL       |                |
// | currency_value          | decimal(15,8) | NO   |     | 1.00000000 |                |
// | ip                      | varchar(40)   | NO   |     | NULL       |                |
// | forwarded_ip            | varchar(40)   | NO   |     | NULL       |                |
// | user_agent              | varchar(255)  | NO   |     | NULL       |                |
// | accept_language         | varchar(255)  | NO   |     | NULL       |                |
// | date_added              | datetime      | NO   |     | NULL       |                |
// | date_modified           | datetime      | NO   |     | NULL       |       

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
        Schema::drop('sales_orders');
    }
}