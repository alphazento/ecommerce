<?php

namespace Zento\Backend\Http\Controllers\Api;

use Request;
use Route;
use Zento\Catalog\Providers\Facades\CategoryService;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class ModelController extends ApiBaseController
{
    /**
     * update a model which has dynamic attribute
     * @group Dynamic Attribute
     * @urlParam id required number model's id
     * @urlParam model required string model's type
     */
    public function updateModel()
    {
        $id = Route::input('id');
        $modelName = Route::input('model');
        $model = null;
        switch ($modelName) {
            case 'category':
                $model = CategoryService::getCategoryById($id);
                break;
            case 'product':
                $model = ProductService::getProductById($id);
                break;
        }
        if ($model) {
            $attrs = Request::all();
            foreach ($attrs as $key => $name) {
                $model->{$key} = $name;
            }
            $model->exists = true;
            $model->push();
            return $this->withData($attrs);
        }
        return $this->error(404);
    }
}
