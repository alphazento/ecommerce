<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionItemTable extends Migration
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

        if (!$builder->hasTable('permission_items')) {
            $builder->create('permission_items', function (Blueprint $table) {
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

            DB::connection(\Zento\Acl\Consts::DB)->table('permission_items')->insert([
                [
                    'scope' => 0,
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
        $this->getBuilder()->drop('permission_items');
    }
}
