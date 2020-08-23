<?php

namespace Zento\VueTheme\Http\Controllers;

use BladeTheme;
use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\ORM\Product;

class CatalogController extends \Zento\BladeTheme\Http\Controllers\CatalogController
{
    public function category()
    {
        if ($view = parent::categories()) {
            $data = $view->getData();
            $category = $data['pageData']['category'];

            BladeTheme::breadcrumb('/', 'Home')
                ->breadcrumb(url($category->url), $category->name);
            return $view;
        }
    }

    public function product()
    {
        if ($view = parent::product()) {
            $data = $view->getData();
            $product = $data['product'];
            $category = $data['category'];
            $view->with('currentCateId', $category->id)
                ->with('jsonFields', [
                ]);
            return $view;
        }
    }
}
