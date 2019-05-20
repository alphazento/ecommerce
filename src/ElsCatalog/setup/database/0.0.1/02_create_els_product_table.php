<?php

use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\PackageManager;

require(PackageManager::packagePath('Zento_Catalog', ['setup', 'database', '0.0.1', '03_create_product_table.php']));

class CreateElsProductTable extends \CreateProductTable
{
    protected function getBuilder() {
        return Schema::connection('elasticsearch')->fromOrmModel(Product::class, function($table) {
            $table->removeColumn('price')->float('price');
            $table->removeColumn('cost')->float('cost');
            $table->string('category')->keyword(true)->index('not_analyzed');
        });
    }
}