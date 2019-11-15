<?php

namespace Zento\VueDesktopTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class GeneralController extends \Zento\BladeTheme\Http\Controllers\GeneralController
{
    use TraitControllerPrepare;
    public function home() {
        $request = Request::create('/home', 'GET', []);

        $items = Product::limit(9)->get();
        $pagination = new \Zento\Kernel\Booster\Pagination\LengthAwarePaginator($items, 1, 1, 1);
        $view = parent::home();
        $view->with('pagination', $pagination);
        return $view;
    }
}
