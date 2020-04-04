<?php

namespace Zento\Catalog\Http\Controllers\Api;

use Route;
use Request;
use ShareBucket;
use CategoryService;
use Zento\Kernel\Consts;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Catalog\Model\ORM\Category;
use Illuminate\Support\Arr;

class CategoryController extends ApiBaseController
{
    /**
     * list category tree
     * @group Catalog
     */
    public function categoriesTree() {
        $all = Request::get('all', false);
        $tree = CategoryService::tree(!$all);
        return $this->with('tree_conf',CategoryService::treeConfigs())->withData($tree);
    }

    /**
     * Retrieves specified categories by IDs
     * @group Catalog
     * @urlParam ids required string category IDs Example:3,4
     */
    public function categories() {
        $ids = explode(',', Route::input('ids'));
        $ids = array_unique($ids);
        $categories = [];
        foreach($ids as $id) {
            $categories[] = CategoryService::getCategoryById($id);
        }
        return $this->withData($categories);
    }

    /**
     * set category's attribute's value
     * @group Catalog
     * @urlParam attribute required string Attribute name
     * @bodyParam value required string Attribute value
     */
    public function setAttribute() {
        if ($id = Route::input('id')) {
            if ($category = CategoryService::getCategoryById($id)) {
                $attribute = Route::input('attribute');
                $value = Request::get('value');
                $category->{$attribute} = $value;
                $category->push();
                return $this->withData($category);
            }
        }
        return $this->error(420)->with($attribute, $value);
    }

    /**
     * store a new category
     * @group Catalog
     * @responseModel \Zento\Catalog\Model\ORM\Category
     */
    public function newCategory() {
        $data = Request::all();
        unset($data['id']);

        $category = new Category();
        $filedList = $category->getTableFields();
        $fileds = Arr::only($data, $category->getTableFields());
        $category->fill($fileds);
        $category->save();
        //must reload to make sure it will load dynamic attributes
        if ($category = CategoryService::getCategoryById($category->id)) {
            $dynAttrs = Arr::except($data, $category->getTableFields());
            foreach($dynAttrs as $attribute => $value) {
                $category->{$attribute} = $value;
            }
            $category->push();
        }
        return $this->withData($category);
    }

    /**
     * get products belongs a category
     * @group Catalog
     * @urlParam id required category id
     * @queryParam page number pagination's page
     * @queryParam per_page number pagination's per_page
     * @responseCollectionPagination \Zento\Catalog\Model\ORM\Product
     */
    public function productsOfCategory() {
        $category = CategoryService::getCategoryById(Route::input('id'));
        \zento_assert($category);
        return $this->with('category', $category)
                    ->with('products', $category->products()->paginate(Request::get('per_page', 9)));
    }

    public function newProductSection() {
        // $categories[] = CategoryService::getCategoryById(19);
        $categories[] = CategoryService::getCategoryById(22);
        $categories[] = CategoryService::getCategoryById(29);
        $categories[] = CategoryService::getCategoryById(33);
        $categories[] = CategoryService::getCategoryById(8);

        $collection = [];
        foreach($categories as $category) {
            $collection[] = ['name' => $category->name, 'products' => $category->products()->limit(6)->get()];
        }
        return $this->withData($collection);
    }
}
