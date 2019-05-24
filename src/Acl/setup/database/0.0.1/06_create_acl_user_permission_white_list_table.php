<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclUserPermissionWhiteListTable extends Migration
{
    protected function getBuilder() {
        return Schema::connection(\Zento\Acl\Consts::DB);
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $builder = $this->getBuilder();

        if (!$builder->hasTable('acl_user_permission_white_lists')) {
            $builder->create('acl_user_permission_white_lists', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->integer('user_id')->unsigned();
                $table->integer('item_id')->unsigned();
                $table->timestamps();

                $table->foreign('item_id')
                        ->references('id')
                        ->on('permission_items')
                        ->onDelete('cascade');
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
        $this->getBuilder()->drop('acl_user_permission_white_lists');
    }
}
