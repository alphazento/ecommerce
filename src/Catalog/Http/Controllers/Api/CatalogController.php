<?php

namespace Zento\Catalog\Http\Controllers\Api;

use CategoryService;
use ProductService;
use Product;
use Route;
use Request;
use Registry;
use View;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Catalog\Model\DB\CartridgeSeries;
use Zento\Catalog\Model\Search\LegacySearch as Adapter;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\DB\CartridgeSeries\ProductCrossTable;
use Zento\Catalog\Model\DB\CartridgeSeries\Description;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends ApiBaseController
{
    public function categoriesTree() {
        $all = Request::get('all', false);
        return $this->withData(CategoryService::tree(!$all));
    }

    public function categories() {
        $ids = explode('/', Route::input('ids'));
        $ids = array_unique($ids);
        $categories = [];
        foreach($ids as $id) {
            $categories[] = CategoryService::getCategoryById($id);
        }
        return $this->withData($categories);
    }

    /**
     * used for admin
     * co-work with react config components
     *
     * @return void
     */
    public function categoryValues() {
        $id = Route::input('id');
        $category = CategoryService::getCategoryById($id);
        \zento_assert($category);
        return $this->withData($category);
    }

    public function setCategoryField() {
        if ($id = Route::input('id')) {
            if ($category = CategoryService::getCategoryById($id)) {
                $field = Route::input('field');
                $value = Request::get('value');
                $category->{$field} = $value;
                $category->save();
                return $this->with($field, $value);
            }
        }
        return $this->error(420)->with($field, $value);
    }

    public function productsOfCategory() {
        $category = CategoryService::getCategoryById(Route::input('id'));
        \zento_assert($category);
        return $this->with('category', $category)
                    ->with('products', $category->products()->paginate(Request::get('per_page', 9)));
    }

    public function product() {
        $product = ProductService::getProductById(Route::input('id'));
        return $this->withData($product);
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
