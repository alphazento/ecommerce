<?php

namespace Zento\Catalog\Http\Controllers;

use PrinterCategory;
use Product;
use Route;
use Request;
use Registry;
use Store;
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
    public function home() {
        ThemeManager::prependLocation(base_path('vendor/alphazento/ecommerce/src/MainTheme/resources/views'));
        // $content_top_modules = [];
        // $content_top_modules[] = (new \Zento\CMS\View\Banner)->load(7, 100, 100, 'extension.module.slideshow');
        // $content_top_modules[] = ['extension.module.featured', ['products' => \Zento\Catalog\Model\ORM\Product::limit(10)->get()]];

        return (new \Zento\CMS\Services\LayoutService)->render('home', 'page.home', [
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
}
