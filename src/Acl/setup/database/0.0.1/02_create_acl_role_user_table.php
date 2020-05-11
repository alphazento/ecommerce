<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Zento\Acl\Consts;

class CreateAclRoleUserTable extends Migration
{
    protected function getBuilder()
    {
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

        if (!$builder->hasTable('acl_role_users')) {
            $builder->create('acl_role_users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('scope', 16)->index();
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();
                $table->timestamps();

                $table->unique(['scope', 'user_id', 'role_id']);
                $table->foreign('role_id')
                    ->references('id')
                    ->on('acl_roles')
                    ->onDelete('cascade');
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_role_users')->insert([
                [
                    'scope' => Consts::BACKEND_SCOPE,
                    'user_id' => 1,
                    'role_id' => 1,
                ],
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
        $this->getBuilder()->drop('acl_role_users');
    }
}
