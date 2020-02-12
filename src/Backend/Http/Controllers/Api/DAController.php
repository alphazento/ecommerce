<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\ORM\Product;
use Zento\Customer\Model\ORM\Customer;


class DAController extends ApiBaseController
{
    public function getAttributes() {
        $model = Route::input('model');
        return $this->with('default', with(new DynamicAttribute)->defaultDynAttr($model))
            ->withData(DynamicAttribute::where('parent_table', $model)->get());
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
        $data = Request::get('attributes');
        unset($data['id']);
        if (!($data['default_value'] ?? false)) {
            $data['default_value'] = '';
        }

        $model = null;
        switch($data['parent_table']) {
            case 'categories':
                $model = new Category();
            break;
            case 'products':
                $model = new Product();
            break;
            case 'customers':
                $model = new Customer();
            break;
        }
        if (!$model) {
            throw new \Exception('Unkonw parent model ' . $data['parent_table']);
        }

        list($attrId, $tableName) = DanamicAttributeFactory::createRelationShipORM($model,
            $data['attribute_name'], 
            [$data['attribute_type']], 
            $data['single'],
            $data['with_value_map'],
            $data['default_value']
        );
        $data['attribute_table'] = $tableName;
        $model = DynamicAttribute::create($data);
        return $this->withData($model->toArray());
    }
}
