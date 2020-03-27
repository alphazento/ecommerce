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
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeInSet;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DynamicAttributeController extends ApiBaseController
{
    /**
     * retrieve a dynamic attribute's details
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":{
     * "parent_table": "",
     * "name": "",
     * "front_label": "",
     * "front_group": "",
     * "front_component": "",
     * "admin_label": "",
     * "admin_group": "",
     * "admin_component": "",
     * "attribute_table": "",
     * "attribute_type": "",
     * "default_value": "",
     * "single": true,
     * "with_value_map": false,
     * "swatch": false,
     * "searchable": false,
     * "sort": 0,
     * "active": true,
     * "created_at": "",
     * "updated_at": "",
     * }
     */
    public function attribute(){
        if ($id = Route::input('id')) {
            if ($attr = DynamicAttribute::find($id)) {
                return $this->withData($attr->toArray());
            }
        }
        return $this->error(404, 'Not found');
    }


    /**
     * store a dynamic attribute's details
     * @group Dynamic Attribute
     * @authenticated
     * @response {"success":true,"code":201,"locale":"en","message":"",
     * "data":{
     * "parent_table": "",
     * "name": "",
     * "front_label": "",
     * "front_group": "",
     * "front_component": "",
     * "admin_label": "",
     * "admin_group": "",
     * "admin_component": "",
     * "attribute_table": "",
     * "attribute_type": "",
     * "default_value": "",
     * "single": true,
     * "with_value_map": false,
     * "swatch": false,
     * "searchable": false,
     * "sort": 0,
     * "active": true,
     * "created_at": "",
     * "updated_at": "",
     * }
     */
    public function store() {
        $data = Request::get('attributes');
        unset($data['id']);
        if (!($data['default_value'] ?? false)) {
            $data['default_value'] = '';
        }

        $model = null;
        switch(strtolower($data['parent_table'])) {
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
            $data['name'], 
            [$data['attribute_type']], 
            $data['single'],
            $data['with_value_map'],
            $data['default_value']
        );
        $data['attribute_table'] = $tableName;
        $model = DynamicAttribute::create($data);
        return $this->withData($model->toArray());
    }

    /**
     * update a dynamic attribute's details
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @bodyParam attributes required Json formated dynamic attribute object
     * @response {"success":true,"code":201,"locale":"en","message":"",
     * "data":{
     * "parent_table": "",
     * "name": "",
     * "front_label": "",
     * "front_group": "",
     * "front_component": "",
     * "admin_label": "",
     * "admin_group": "",
     * "admin_component": "",
     * "attribute_table": "",
     * "attribute_type": "",
     * "default_value": "",
     * "single": true,
     * "with_value_map": false,
     * "swatch": false,
     * "searchable": false,
     * "sort": 0,
     * "active": true,
     * "created_at": "",
     * "updated_at": "",
     * }
     */
    public function update() {
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

    /**
     * retrieve dynamic attributes of a Model
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam model required The model name
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":['Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute']
     */
    public function attributesOfModel() {
        $model = Str::plural(Route::input('model'));
        return $this->with('default', with(new DynamicAttribute)->defaultDynAttr($model))
            ->withData(DynamicAttribute::where('parent_table', $model)->get());
    }

    /**
     * retrieve dynamic attribute set of a Model
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam model required The model name
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":['Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet']
     */
    public function attributeSetsOfModel() {
        $model = Str::plural(Route::input('model'));
        $collection = DynamicAttributeSet::where('model', $model);
        if (Request::input('with_attributes')) {
            $collection->with('attributes');
        }
        return $this->with('default', with(new DynamicAttributeSet)->defaultDynAttr($model))
            ->withData($collection->get());
    }

    /**
     * Retrieves a dynamic attribute set
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":['Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet']
     */
    public function attributeSet() {
        $attr_set_id = Route::input('id');
        return $this->withData(DynamicAttributeSet::with('attributes')->find($attr_set_id));
    }

    /**
     * update a dynamic attribute set's detail
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute set.
     * @bodyParam attributes.name string the dynamic attribute set's name
     * @bodyParam attributes.description string the dynamic attribute set's description
     * @bodyParam attributes.active boolean the dynamic attribute set's active
     */
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

    /**
     * create a dynamic attribute set
     * @group Dynamic Attribute
     * @authenticated
     */
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

    /**
     * add a dynamic attribute to a set
     * @group Dynamic Attribute
     * @authenticated
     */
    public function addToSet() {
        $attr_set_id = Route::input('attr_set_id');
        $attr_id = Route::input('attr_id');
        $relationShip = new DynamicAttributeInSet();
        $relationShip->attribute_set_id = $attr_set_id;
        $relationShip->attribute_id = $attr_id;
        $relationShip->save();
        return $this->withData($relationShip);
    }

    /**
     * remove a dynamic attribute from a set
     * @group Dynamic Attribute
     * @authenticated
     */
    public function deleteFromSet() {
        $attr_set_id = Route::input('attr_set_id');
        $attr_id = Route::input('attr_id');
        DynamicAttributeInSet::where('attribute_set_id', $attr_set_id)
            ->where('attribute_id', $attr_id)
            ->delete();
        return $this;
    }

    /**
     * retrieve a dynamic attribute's map values when its value can has a value mapping
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number dynamic attribute's ID
     */
    public function values(){
        if ($id = Route::input('id')) {
            if ($attr = DynamicAttribute::with('options')->find($id)) {
                return $this->withData($attr->toArray());
            }
        }
        return $this->error(404, 'Not found');
    }

    /**
     * retrieve a dynamic attribute set which the attribute belongs to
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number dynamic attribute's ID
     */
    public function belongsSets() {
        if ($id = Route::input('id')) {
            if ($attr = DynamicAttribute::with('sets')->find($id)) {
                return $this->withData($attr->toArray());
            }
        }
        return $this->error(404, 'Not found');
    }
}
