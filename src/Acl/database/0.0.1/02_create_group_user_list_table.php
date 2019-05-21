<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserListTable extends Migration
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

        if (!$builder->hasTable('group_user_list')) {
            $builder->create('group_user_list', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->integer('user_id')->unsigned();
                $table->integer('group_id')->unsigned();
                $table->timestamps();

                $table->unique(['scope', 'user_id', 'group_id']);
                $table->foreign('group_id')
                    ->references('id')
                    ->on('user_groups')
                    ->onDelete('cascade');
            });

            DB::connection(\Zento\Acl\Consts::APC_DB)->table('group_user_list')->insert([
                [
                    'scope' => 0,
                    'user_id' => 1,
                    'group_id' => 1
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
        $this->getBuilder()->drop('group_user_list');
    }
}
