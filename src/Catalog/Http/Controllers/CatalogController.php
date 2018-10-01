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
        // echo base_path('vendor/alphazento/ecommerce/src/TwigTheme/resources/views');die;
        return view('page.home', 
        [
            'direction' => 'ltr', 
            'lang' => 'en', 
            'logo'=>'', 
            'name' =>'Zento',
            'products' => \Zento\Catalog\Model\ORM\Product::limit(5)->get(),
            'content_top_modules' => ['extension.module.featured']
        ]);
    }
}
