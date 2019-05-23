<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclUserGroupTable extends Migration
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
        if (!$builder->hasTable('acl_user_groups')) {
            $builder->create('acl_user_groups', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->string('name', 128);
                $table->string('description', 255)->default('');
                $table->boolean('active')->default(1);
                $table->timestamps();

                $table->unique(['scope', 'name']);
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_user_groups')->insert([
                [
                    'scope' => 0,
                    'name' => 'root',
                    'description' => 'Users in the group will have root permission. That means it can do anything.',
                    'active' => 1
                ],
                [
                    'scope' => '0',
                    'name' => 'guest',
                    'description' => 'Admin Guest user group.',
                    'active' => 1
                ],
                [
                    'scope' => '1',
                    'name' => 'guest',
                    'description' => 'Frontend Guest user group.',
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
        $this->getBuilder()->drop('acl_user_groups');
    }
}
