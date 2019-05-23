<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclGroupPermissionTable extends Migration
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

        if (!$builder->hasTable('acl_group_permissions')) {
            $builder->create('acl_group_permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->integer('group_id')->unsigned();
                $table->integer('item_id')->unsigned();
                $table->timestamps();

                $table->unique(['group_id', 'item_id']);
                $table->foreign('group_id')
                    ->references('id')
                    ->on('user_groups')
                    ->onDelete('cascade');

                $table->foreign('item_id')
                    ->references('id')
                    ->on('permission_items')
                    ->onDelete('cascade');
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_group_permissions')->insert([
                [
                    'scope' => 0,
                    'group_id' => 1,
                    'item_id' => 1,
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getBuilder()->drop('acl_group_permissions');
    }
}
