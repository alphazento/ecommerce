<?php

use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\PackageManager;

require(PackageManager::packagePath('Zento_Catalog', ['setup', 'database', '0.0.1', '03_create_product_table.php']));

class CreateElsProductTable extends \CreateProductTable
{
    protected function getBuilder() {
        return Schema::connection('elasticsearch')->fromOrmModel(Product::class, function($table) {
            // $table->removeColumn('name')->keyword('name');
            $table->string('categories')->keyword(true)->index('not_analyzed');
        });
    }
}