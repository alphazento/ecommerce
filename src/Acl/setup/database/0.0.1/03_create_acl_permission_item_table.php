<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclPermissionItemTable extends Migration
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

        if (!$builder->hasTable('acl_permission_items')) {
            $builder->create('acl_permission_items', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->string('groupname', 255);
                $table->string('name', 255);
                $table->string('method', 16);
                $table->string('uri', 128);
                $table->boolean('removed')->default(0);
                $table->boolean('active')->default(1);
                $table->string('description', 255)->default('');
                $table->timestamps();
                $table->unique(['method', 'uri']);
            });

            DB::connection(\Zento\Acl\Consts::DB)->table('acl_permission_items')->insert([
                [
                    'scope' => Consts::ADMIN_SCOPE,
                    'groupname' => 'root',
                    'name' => 'Admin super permiision',
                    'method' => '*',
                    'uri' => '*',
                    'description' => 'Admin Root permission.'
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
        $this->getBuilder()->drop('acl_permission_items');
    }
}
