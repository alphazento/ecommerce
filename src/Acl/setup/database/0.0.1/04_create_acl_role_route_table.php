<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclRoleRouteTable extends Migration
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

        if (!$builder->hasTable('acl_role_routes')) {
            $builder->create('acl_role_routes', function (Blueprint $table) {
                $table->increments('id');
                $table->smallInteger('scope');  //0=> admin, 1=>frontend
                $table->integer('role_id')->unsigned();
                $table->integer('route_id')->unsigned();
                $table->timestamps();

                $table->unique(['role_id', 'route_id']);
                $table->foreign('role_id')
                    ->references('id')
                    ->on('acl_roles')
                    ->onDelete('cascade');

                $table->foreign('route_id')
                    ->references('id')
                    ->on('acl_routes')
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
        $this->getBuilder()->drop('acl_role_routes');
    }
}
