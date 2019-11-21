<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Catalog\Providers\Facades\CategoryService;

class ModelController extends ApiBaseController
{
    public function updateModel() {
        $id = Route::input('id');
        $modelName = Route::input('model');
        $model = null;
        switch($modelName) {
            case 'category':
                $model = CategoryService::getCategoryById($id);
                break;
            case 'product':
                $model = ProductService::getProductById($id);
                break;
        }
        if ($model) {
            $attrs = Request::all();
            foreach($attrs as $key => $name) {
                $model->{$key} = $name;
            }
            $model->exists = true;
            $model->push();
            return $this->withData($attrs);
        }
        return $this->error(404);
    }
}
