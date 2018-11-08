<?php

namespace Zento\Catalog\Http\Controllers;

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

class ApiCatalogController extends Controller
{
    public function options()
    {
        
    }

    public function categories() {
        return CategoryService::tree();
    }

    public function category() {
        $ids = explode('/', Route::input('ids'));
        $category = CategoryService::getCategoryById(last($ids));
        \zento_assert($category);

        return $category;
    }
    // public function category() {
    //     $category = CategoryService::getCategoryById(Route::input('id'));
    //     \zento_assert($category);

    //     return $category;
    // }

    public function productsOfCategory() {
        $category = CategoryService::getCategoryById(Route::input('id'));
        \zento_assert($category);
        return $category->products;
    }

    public function products() {
        return \Zento\Catalog\Model\ORM\Product::limit(12);
    }

    public function product() {
        $category = CategoryService::getCategoryById(30);
        $product = $category->products[0];
        return $product;
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
        return $collection;
    }

    public function shoppingCollectionSection() {
        return [
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
            ];
    }
}
