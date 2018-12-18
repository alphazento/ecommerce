<?php

namespace Zento\Catalog\Http\Controllers\Api;

use CategoryService;
use Product;
use Route;
use Request;
use Registry;
use View;
use App\Http\Controllers\Controller;
use Zento\Catalog\Model\DB\CartridgeSeries;
use Zento\Catalog\Model\Search\LegacySearch as Adapter;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\DB\CartridgeSeries\ProductCrossTable;
use Zento\Catalog\Model\DB\CartridgeSeries\Description;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    public function categoriesTree() {
        return ['status'=>200, 'data'=> CategoryService::tree()];
    }
    
    public function categories() {
        return ['status'=>200, 'data'=> CategoryService::tree()];
    }

    public function category() {
        $ids = explode('/', Route::input('ids'));
        $category = CategoryService::getCategoryById(last($ids));
        \zento_assert($category);

        return ['status'=>200, 'data'=> $category];
    }

    public function productsOfCategory() {
        $category = CategoryService::getCategoryById(Route::input('id'));
        \zento_assert($category);
        // $page_size = Request::get('page_size', 9);
        // $page = Request::get('page', 1);
        return ['status'=>200, 'data'=>$category->products()->paginate(Request::get('per_page', 9))];
    }

    public function products() {
        return ['status'=>200, 'data'=> \Zento\Catalog\Model\ORM\Product::limit(12)];
    }

    public function product() {
        $category = CategoryService::getCategoryById(30);
        $product = $category->products[0];
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

    public function shoppingCollectionSection() {
        return ['status'=>200, 'data'=> 
            [
                [
                    'name' => 'Spring 2018',
                    'image' => 'https://alphazento.local.test/images/catalog/product/o/t/ottoman.jpg'
                ],
                [
                    'name' => 'Productivity',
                    'image' => 'https://alphazento.local.test/images/catalog/product/o/t/ottoman.jpg'
                ],
                [
                    'name' => 'Live boost',
                    'image' => 'https://alphazento.local.test/images/catalog/product/o/t/ottoman.jpg'
                ],
                [
                    'name' => 'Mobile',
                    'image' => 'https://alphazento.local.test/images/catalog/product/o/t/ottoman.jpg'
                ]
            ]
        ];
    }
}
