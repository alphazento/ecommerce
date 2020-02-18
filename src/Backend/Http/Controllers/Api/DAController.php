<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\ORM\Product;
use Zento\Customer\Model\ORM\Customer;
use Illuminate\Support\Arr;

class DAController extends ApiBaseController
{
    public function getAttribute(){
        if ($id = Route::input('id')) {
            if ($attr = DynamicAttribute::find($id)) {
                return $this->withData($attr->toArray());
            }
        }
        return $this->error(404, 'Not found');
    }

    public function getModelAttributes() {
        $model = Route::input('model');
        return $this->with('default', with(new DynamicAttribute)->defaultDynAttr($model))
            ->withData(DynamicAttribute::where('parent_table', $model)->get());
    }

    public function updateAttribute() {
        $id = Route::input('id');

        if ($model = DynamicAttribute::find($id)) {
            $model->forceFill(Request::get('attributes'));
            if (!$model->default_value) {
                $model->default_value = '';
            }
            $model->save();
            return $this->withData($model);
        }
        return $this->error(404, 'Item not found.');
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

    public function getModelAttributeSets() {
        $model = Route::input('model');
        $collection = DynamicAttributeSet::where('model', $model);
        if (Request::input('with_attributes')) {
            $collection->with('attributes');
        }
        return $this->with('default', with(new DynamicAttributeSet)->defaultDynAttr($model))
            ->withData($collection->get());
    }

    public function getAttributeSet() {
        $attr_set_id = Route::input('id');
        return $this->withData(DynamicAttributeSet::with('attributes')->find($attr_set_id));
    }

    public function updateAttributeSet() {
        $id = Route::input('id');

        if ($model = DynamicAttributeSet::find($id)) {
            $data = Arr::only(Request::get('attributes'), ['name', 'description', 'active']);
            $model->fill($data);
            $model->save();
            return $this->withData($model);
        }
        return $this->error(404, 'Item not found.');
    }

    public function createAttributeSet() {
        $data = Request::get('attributes');
        unset($data['id']);
        try {
            $model = DynamicAttributeSet::create($data);
            return $this->withData($model);
        } catch(\Exception $e) {
            return $this->error(400, $e->getMessage());
        }
    }

    public function addAttributeToSet() {
        return $this->success('OK');
    }

    public function deleteAttributeFromSet() {
        return $this->success('OK');
    }
}
