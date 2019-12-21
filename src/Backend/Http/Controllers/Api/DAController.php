<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;

use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;


class DAController extends ApiBaseController
{
    public function getAttributes() {
        $model = Route::input('model');
        return $this->withData(DynamicAttribute::where('parent_table', $model)->get());
    }

    public function updateAttribute() {
        $id = Route::input('id');

        if ($model = DynamicAttribute::find($id)) {
            $model->forceFill(Request::get('attributes'));
            $model->default_value = '';
            $model->save();
        }
        return $this->withData(Request::get('attributes'));
    }

    public function createAttribute() {
        $model = new DynamicAttribute();
        $model->forceFill(Request::get('attributes'));
        $model->default_value = '';
        $model->save();

        return $this->withData($model->toArray());
    }
}
