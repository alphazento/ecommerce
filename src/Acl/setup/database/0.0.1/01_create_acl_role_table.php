<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Zento\Acl\Consts;

class CreateAclRoleTable extends Migration
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
        if (!$builder->hasTable('acl_roles')) {
            $builder->create('acl_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('scope', 16)->index(); // Zento\Acl\Consts
                $table->string('name', 128);
                $table->string('description', 255)->default('');
                $table->boolean('active')->default(1);
                $table->timestamps();

                $table->unique(['scope', 'name']);
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_roles')->insert([
                [
                    'scope' => Consts::BACKEND_SCOPE,
                    'name' => 'root',
                    'description' => 'Super Administrator',
                    'active' => 1,
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
        $this->getBuilder()->drop('acl_roles');
    }
}
