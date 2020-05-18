<?php

namespace Zento\VueTheme\Http\Controllers;

use Zento\BladeTheme\Http\Controllers\GeneralController as BaseGeneralController;
use Zento\Catalog\Model\ORM\Product;

class GeneralController extends BaseGeneralController
{
    public function home()
    {
        $view = parent::home();

        $items = Product::richMode()->limit(8)->get();
        $topsale = new \Zento\Kernel\Booster\Pagination\LengthAwarePaginator($items, 1, 1, 1);

        $carousel = config('vuetheme.hompage.carousel');
        $carousel = $carousel['images'] ?? [];

        $gallery = config('vuetheme.hompage.collection.gallery');
        $gallery = $gallery['cards'] ?? [];

        $view->with(['pageData' => compact('carousel', 'topsale', 'gallery')]);
        return $view;
    }
}
