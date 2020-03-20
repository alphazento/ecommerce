<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclRoleTable extends Migration
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
        if (!$builder->hasTable('acl_roles')) {
            $builder->create('acl_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('scope', 16)->index();  // Zento\Acl\Consts
                $table->string('name', 128);
                $table->string('description', 255)->default('');
                $table->boolean('active')->default(1);
                $table->timestamps();

                $table->unique(['scope', 'name']);
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_user_groups')->insert([
                [
                    'scope' => Consts::ADMIN_SCOPE,
                    'name' => 'root',
                    'description' => 'Users in the group will have root permission. That means it can do anything.',
                    'active' => 1
                ],
                [
                    'scope' => Consts::GUEST_SCOPE,
                    'name' => 'guest',
                    'description' => 'Guest user.',
                    'active' => 1
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
        $this->getBuilder()->drop('acl_roles');
    }
}
