<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\DB\Category as CategoryModel;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class CategoryService {
    protected $modelClass;
    
    public function load($idOrIds) {
        return CategoryModel::find($id);
    }

    public function register($modelClass) {
        $this->modelClass = $modelClass;
    }

    public function __call($method, $argv) {
    }
}