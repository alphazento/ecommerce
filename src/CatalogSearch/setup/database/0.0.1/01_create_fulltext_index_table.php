<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFulltextIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fulltext_indices', function (Blueprint $table) {
            $table->integer('product_id')->index();
            $table->string('field_name', '64');
            $table->longtext('data_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fulltext_indices');
    }
}
