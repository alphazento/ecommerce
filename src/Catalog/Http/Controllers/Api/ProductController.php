<?php

namespace Zento\Catalog\Http\Controllers\Api;

use Route;
use Request;
use ShareBucket;
use ProductService;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Kernel\Facades\DanamicAttributeFactory;

class ProductController extends ApiBaseController
{
    /**
     * Retrieves product by id
     * @group Catalog
     * @urlParam id required number product id Example:1
     */
    public function product() {
        $product = ProductService::getProductById(Route::input('id'));
        return $this->withData($product);
    }

    /**
     * create a new product 
     * @group Catalog
     * @responseModel \Zento\Catalog\Model\ORM\Product
     */
    public function create() {
        $data = Request::all();
        $product = ProductService::newInstanceBaseTypeId($data['model_type']);
        $filedList = $product->getTableFields();
        $fileds = Arr::only($data, $product->getTableFields());
        $product->fill($fileds);
        $product->save();
        ShareBucket::put(Consts::MODEL_RICH_MODE, true);
        $product = ProductService::getProductById($product->id);
        $dynAttrs = Arr::except($data, $product->getTableFields());
        foreach($dynAttrs as $attribute => $value) {
            $product->{$attribute} = $value;
        }
        $product->update();
        return $this->withData($product->toArray());
    }

    /**
     * update a product's attribute's value
     * @group Catalog
     * @urlParam attribute required string Attribute name
     * @bodyParam value required string Attribute value
     */
    public function setAttribute() {
        if ($id = Route::input('id')) {
            if ($product = ProductService::getProductById($id)) {
                $attribute = Route::input('attribute');
                $value = Request::get('value');
                $product->{$attribute} = $value;
                if (!$product->push()) {
                    $this->error(200);
                }
                return $this->withData($product);
            }
        }
        return $this->error(420)->with($attribute, $value);
    }
}
