<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use App\Http\Controllers\Controller;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Catalog\Providers\Facades\CategoryService;

class ModelController extends Controller
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
            return ['status'=>200, 'data' => $attrs];
        }
        return ['status'=>404, 'data' => 'Not found'];
    }
}
