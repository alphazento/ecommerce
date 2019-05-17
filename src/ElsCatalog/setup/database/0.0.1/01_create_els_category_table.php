<?php

class CreateElsCategoryTable extends \CreateCategoryTable
{
    protected function getBuilder() {
        return Schema::connection('elasticsearch');
    }
}