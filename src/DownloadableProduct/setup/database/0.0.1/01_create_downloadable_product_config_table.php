<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadableProductConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloadable_product_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->boolean('quantitative')->default(0);  //0 means only allow add qty 1
            $table->integer('downloadable')->unsigned()->default(0);
            $table->string('download_url');
            $table->timestamps();

            $table->foreign('product_id')
                    ->references('id')
                    ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('downloadable_product_configs');
    }
}