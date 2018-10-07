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
        // $content_top_modules = [];
        // $content_top_modules[] = (new \Zento\CMS\View\Banner)->load(7, 100, 100, 'extension.module.slideshow');
        // $content_top_modules[] = ['extension.module.featured', ['products' => \Zento\Catalog\Model\ORM\Product::limit(10)->get()]];

        return (new \Zento\CMS\Services\LayoutService)->render('home', 'page.home', [
            'page_name' => 'home',
            'direction' => 'ltr', 
            'lang' => 'en', 
            'logo'=>'', 
            'name' =>'Zento']);
        // return view('page.home', 
        // [
        //     'direction' => 'ltr', 
        //     'lang' => 'en', 
        //     'logo'=>'', 
        //     'name' =>'Zento',
        //     'content_top' => $content_top_modules
        // ]);
    }

    public function category() {
        $ids = explode('/', Route::input('ids'));
        // CategoryService::getCategoryById($id);
        return (new \Zento\CMS\Services\LayoutService)->render('category', 'page.category', 
        [
            'page_name' => 'category',
            'direction' => 'ltr', 
            'lang' => 'en', 
            'logo'=>'', 
            'name' =>'Zento',

            'heading_title' => 'category',
            'description' => 'category description',
            'thumb' => null,
            'products' => null,
            'category_ids' => $ids
        ]);
    }
}
