<?php

use Zento\Kernel\Facades\PackageManager;

require(PackageManager::packagePath('Zento_Catalog', ['setup', 'database', '0.0.1', '01_create_category_table.php']));

class CreateElsCategoryTable extends \CreateCategoryTable
{
    protected function getBuilder() {
        return Schema::connection('elasticsearch');
    }
}