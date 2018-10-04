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
        // echo '<pre>';
        // print_r((new \Zento\CMS\View\Banner)->load(7, 100, 100));die;

        // return \Zento\Catalog\Model\ORM\Product::limit(50)->get()->toArray();
        ThemeManager::prependLocation(base_path('vendor/alphazento/ecommerce/src/MainTheme/resources/views'));
        // $data['column_left'] = View::make('common/column_left');
		// $data['column_right'] = View::make('common/column_right');
		// $data['content_top'] = View::make('common/content_top');
		// $data['content_bottom'] = View::make('common/content_bottom');
		// $data['footer'] = View::make('common/footer');
        // $data['header'] = View::make('common/header');
        
        // return View::make('common.home', $data);
        // echo base_path('vendor/alphazento/ecommerce/src/TwigTheme/resources/views');die;
        $content_top_modules = [];
        $content_top_modules[] = (new \Zento\CMS\View\Banner)->load(7, 100, 100, 'extension.module.slideshow');
        $content_top_modules[] = ['extension.module.featured', []];

        return view('page.home', 
        [
            'direction' => 'ltr', 
            'lang' => 'en', 
            'logo'=>'', 
            'name' =>'Zento',
            'products' => \Zento\Catalog\Model\ORM\Product::limit(50)->get(),
            'content_top_modules' => $content_top_modules
        ]);
    }
}
