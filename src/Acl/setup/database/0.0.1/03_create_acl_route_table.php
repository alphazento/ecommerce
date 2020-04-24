<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclRouteTable extends Migration
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

        if (!$builder->hasTable('acl_routes')) {
            $builder->create('acl_routes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('scope', 16)->index();
                $table->string('group', 255)->index();
                $table->string('method', 16);
                $table->string('uri', 128);
                $table->boolean('acl')->default(1); //value set from code
                $table->boolean('active')->default(1);
                $table->boolean('deleted')->default(0);
                $table->string('description', 255)->default('');
                $table->timestamps();
                $table->unique(['method', 'uri']);
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
        $this->getBuilder()->drop('acl_routes');
    }
}
