<?php

namespace Zento\Catalog\Http\Controllers\Api;

use CategoryService;
use ProductService;
use Product;
use Route;
use Request;
use Registry;
use View;
use App\Http\Controllers\Controller;
use Zento\Catalog\Model\DB\CartridgeSeries;
use Zento\Catalog\Model\Search\LegacySearch as Adapter;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\DB\CartridgeSeries\ProductCrossTable;
use Zento\Catalog\Model\DB\CartridgeSeries\Description;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    public function categoriesTree() {
        $all = Request::get('all', false);
        return ['status'=>200, 'data'=> CategoryService::tree(!$all)];
    }
    
    public function categories() {
        $all = Request::get('all', false);
        return ['status'=>200, 'data'=> CategoryService::tree(!$all)];
    }

    public function category() {
        $ids = explode('/', Route::input('ids'));
        $category = CategoryService::getCategoryById(last($ids));
        \zento_assert($category);

        return ['status'=>200, 'data'=> $category];
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

        return ['status'=>200, 'data'=> $category];
    }

    public function setCategoryField() {
        if ($id = Route::input('id')) {
            if ($category = CategoryService::getCategoryById($id)) {
                $field = Route::input('field');
                $value = Request::get('value');
                $category->{$field} = $value;
                $category->save();
                return ['status' => 200, 'data' => [$field => $value]];
            }
        }
        return ['status' => 420, 'data' => [$field => $value]];
    }

    public function productsOfCategory() {
        $category = CategoryService::getCategoryById(Route::input('id'));
        \zento_assert($category);
        return [
            'status'=>200, 
            'data'=>[
                'category' => $category, 
                'products' => $category->products()->paginate(Request::get('per_page', 9))
            ]
        ];
    }

    public function products() {
        return ['status'=>200, 'data'=> \Zento\Catalog\Model\ORM\Product::limit(12)];
    }

    public function product() {
        $product = ProductService::getProductById(Route::input('id'));
        return ['status'=>200, 'data'=> $product];
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
        return ['status'=>200, 'data'=> $collection];
    }
}
