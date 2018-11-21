<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('firstname', 64);
            $table->string('middlename', 64)->nullable();
            $table->string('lastname', 64);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('remember_token', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('prefix', 40)->nullable();
            $table->string('suffix', 40)->nullable();
            $table->date('dob')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->smallInteger('failures_num')->default(0);
            $table->timestamp('lock_expires')->nullable();
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('customer_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_users');
    }
}