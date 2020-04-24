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
    CONST SUPPORTED_MODELS = [
        'product' => Product::Class,
        'category' => Category::Class,
        'customer' => Customer::Class,

        'products' => Category::Class,
        'categories' => Category::Class,
        'customers' => Customer::Class,
    ];

    CONST UNSUPPORTED_MODEL_ERROR = 'Unsupported parent model';

    /**
     * Retrieves a dynamic attribute's details
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @responseModel \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute
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
     * @responseModel 201 \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute
     * @responseError 400, Unsupported parent model
     */
    public function store() {
        $data = Request::get('attributes');
        unset($data['id']);
        if (!($data['default_value'] ?? false)) {
            $data['default_value'] = '';
        }

        $model = null;
        if ($className = (static::SUPPORTED_MODELS[strtolower($data['parent_table'])] ?? false)) {
            $model = new $className();
        } else {
            return $this->error(400, self::UNSUPPORTED_MODEL_ERROR);
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
     * Update a dynamic attribute's details
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @bodyParam attributes required Json formated dynamic attribute object
     * @responseModel \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute
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
        return $this->error(404, 'Not found.');
    }

    /**
     * Retrieves dynamic attributes of a Model
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam model required The model name
     * @responseCollection \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute
     * @responseError 400, Unsupported parent model
     */
    public function attributesOfModel() {
        $model = Str::plural(Route::input('model'));
        if (static::SUPPORTED_MODELS[strtolower($model)] ?? false) {
            return $this->with('default', with(new DynamicAttribute)->defaultDynAttr($model))
                ->withData(DynamicAttribute::where('parent_table', $model)->get());
        }
        return $this->error(400, self::UNSUPPORTED_MODEL_ERROR);
    }

    /**
     * Retrieves dynamic attribute set of a Model
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam model required The model name
     * @responseCollection \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet
     * @responseError 400, Unsupported parent model
     */
    public function attributeSetsOfModel() {
        $model = Str::plural(Route::input('model'));
        if (static::SUPPORTED_MODELS[strtolower($model)] ?? false) {
            $collection = DynamicAttributeSet::where('model', $model);
            if (Request::input('with_attributes')) {
                $collection->with('attributes');
            }
            return $this->with('default', with(new DynamicAttributeSet)->defaultDynAttr($model))
                ->withData($collection->get());
        }
        return $this->error(400, self::UNSUPPORTED_MODEL_ERROR);
    }

    /**
     * Retrieves a dynamic attribute set
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute.
     * @responseModel \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet
     * @responseError 400, Unsupported parent model
     */
    public function attributeSet() {
        $attr_set_id = Route::input('id');
        if ($attrSet = DynamicAttributeSet::with('attributes')->find($attr_set_id)) {
            return $this->withData($attrSet);
        }
        return $this->error(404, 'Not found.');
    }

    /**
     * update a dynamic attribute set's detail
     * @group Dynamic Attribute
     * @authenticated
     * @urlParam id required number The ID of the dynamic attribute set.
     * @bodyParam attributes.name string the dynamic attribute set's name
     * @bodyParam attributes.description string the dynamic attribute set's description
     * @bodyParam attributes.active boolean the dynamic attribute set's active
     * @responseModel \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet
     */
    public function updateAttributeSet() {
        $id = Route::input('id');
        if ($model = DynamicAttributeSet::find($id)) {
            $data = Arr::only(Request::get('attributes'), ['name', 'description', 'active']);
            $model->fill($data);
            $model->save();
            return $this->withData($model);
        }
        return $this->error(404, 'Not found.');
    }

    /**
     * create a dynamic attribute set
     * @group Dynamic Attribute
     * @authenticated
     * @responseModel 201 \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet
     */
    public function createAttributeSet() {
        $data = Request::get('attributes');
        unset($data['id']);
        $model = $data['model'] ?? 'false';
        if (static::SUPPORTED_MODELS[strtolower($model)] ?? false) {
            try {
                $daSet = DynamicAttributeSet::create($data);
                return $this->withData($daSet)->success(201);
            } catch(\Exception $e) {
                return $this->error(400, $e->getMessage());
            }
        }
        return $this->error(400, self::UNSUPPORTED_MODEL_ERROR);
    }

    /**
     * add a dynamic attribute to a set
     * @group Dynamic Attribute
     * @authenticated
     * @responseModel 201 \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeInSet
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
     * Remove a dynamic attribute from a set
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
     * Retrieves a dynamic attribute's map values when its value can has a value mapping
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
     * Retrieves a dynamic attribute set which the attribute belongs to
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
