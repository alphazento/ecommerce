<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Zento\Acl\Consts;

class CreateAclBlackListTable extends Migration
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

        if (!$builder->hasTable('acl_black_lists')) {
            $builder->create('acl_black_lists', function (Blueprint $table) {
                $table->increments('id');
                $table->string('scope', 16)->indxe();
                $table->integer('user_id')->unsigned();
                $table->integer('route_id')->unsigned();
                $table->timestamps();

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
        $this->getBuilder()->drop('acl_black_lists');
    }
}
