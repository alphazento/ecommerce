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

    public function product() {
        $category = CategoryService::getCategoryById(30);
        $product = $category->products[0];
        return $product;
    }
}
