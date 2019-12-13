<?php

namespace Zento\VueTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class GeneralController extends \Zento\BladeTheme\Http\Controllers\GeneralController
{
    public function home() {
        $items = Product::richMode()->limit(8)->get();
        $pagination = new \Zento\Kernel\Booster\Pagination\LengthAwarePaginator($items, 1, 1, 1);
        $view = parent::home();
        $view->with('pagination', $pagination);
        return $view;
    }
}
