<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use App\Http\Controllers\Controller;

use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;


class DAController extends Controller
{
    public function getAttributes() {
        $model = Route::input('model');
        return ['status'=>200, 'data' => DynamicAttribute::where('parent_table', $model)->get()];
    }

    public function updateAttribute() {
        $id = Route::input('id');

        if ($model = DynamicAttribute::find($id)) {
            $model->forceFill(Request::get('attributes'));
            $model->default_value = '';
            $model->save();
        }
        return ['status'=>200, 'data' => Request::get('attributes')];
    }
}
