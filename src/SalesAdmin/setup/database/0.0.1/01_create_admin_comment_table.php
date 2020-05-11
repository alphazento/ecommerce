<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin_comments')) {
            Schema::create('admin_comments', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('type')->unsigned();
                $table->integer('admin_id')->unsigned();
                $table->integer('order_id')->unsigned();
                $table->string('comment', 255)->default('');
                $table->boolean('notify_to_customer')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl_user_groups');
    }
}
