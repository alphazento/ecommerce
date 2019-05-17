<?php

use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\ShareBucket;

class CreateElsProductTable extends \CreateProductTable
{
    protected function getBuilder() {
        return Schema::connection('elasticsearch')->fromOrmModel(Product::class, function($table) {
            $table->string('categories')->keyword(true)->index('not_analyzed');
        });
    }
}