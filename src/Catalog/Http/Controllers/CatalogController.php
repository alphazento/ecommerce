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

use ThemeManager;

class CatalogController extends Controller
{
    public function __construct() {
        ThemeManager::prependLocation(base_path('vendor/alphazento/ecommerce/src/MainTheme/resources/views'));
    }

    public function home() {
        return (new \Zento\CMS\Services\LayoutService)->render('home', 'page.home');
    }

    public function category() {
        $ids = explode('/', Route::input('ids'));
        $category = CategoryService::getCategoryById(last($ids));
// dd($category->products);
        $product = \Zento\Catalog\Model\ORM\Product::first();
        $product->model = 'test';
        $category = CategoryService::where('id', 13)->first();
        \zento_assert($category);
        // dd($category);
        $product->price = 10111;
dd($product->toArray());
        return (new \Zento\CMS\Services\LayoutService)->render('category', 'page.category', 
        [
            'heading_title' => $category->name,
            'description' => $category->description,
            'thumb' => null,
            'products' => $category->products,
            'category_ids' => $ids
        ]);
    }

    public function product() {
        $category = CategoryService::getCategoryById(30);
        $product = $category->products[0];
        return (new \Zento\CMS\Services\LayoutService)->render('product', 'page.product', ['product' => $product]);
    }
}
