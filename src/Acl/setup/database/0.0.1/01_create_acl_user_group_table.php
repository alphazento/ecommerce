<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

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
                $table->smallInteger('scope');  // Zento\Acl\Consts
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
                    'description' => 'Super Administrator.',
                    'active' => 1
                ],
                [
                    'scope' => Consts::GUEST_SCOPE,
                    'name' => 'guest',
                    'description' => 'Guest user',
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
