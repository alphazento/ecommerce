<?php

namespace Zento\VueDesktopTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class CatalogController extends \Zento\BladeTheme\Http\Controllers\CatalogController
{
    use TraitControllerPrepare;

    public function categories() {
        if ($view = parent::categories()) {
            $data = $view->getData();
            $category = $data['pageData']['category'];
           

            BladeTheme::breadcrumb('/', 'Home')
                ->breadcrumb(url(BladeTheme::getCategoryUrl($category)), $category->name);
            return $view;
        }
    }

    public function products() {
        if ($view = parent::products()) {
            $data = $view->getData();
            $categories = $this->fetchCategories();
            $product = $data['product'];
            BladeTheme::breadcrumb('/', 'Home');
            if ($category = ($product->categories[0] ?? false)) {
                BladeTheme::breadcrumb(BladeTheme::getCategoryUrl($category), $category->name);
            }
            BladeTheme::breadcrumb(BladeTheme::getProductUrl($product), $product->name);
            $view->with('currentCateId', $category->id)
                ->with('categories', $categories)
                ->with('jsonFields', [
                    'physic' =>'物理参数',
                    'electronic'=> '电学参数',
                    'environment'=> '环境参数',
                    'safe'=> '安全认证' ,
                    'wireless'=> '无线性能参数',
                    'rfid'=> 'RFID'
                ]);
            return $view;
        }
    }
}
