<?php

namespace Zento\VueTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class CatalogController extends \Zento\BladeTheme\Http\Controllers\CatalogController
{
    public function category() {
        if ($view = parent::categories()) {
            $data = $view->getData();
            $category = $data['pageData']['category'];
           
            BladeTheme::breadcrumb('/', 'Home')
                ->breadcrumb(url(BladeTheme::getCategoryUrl($category)), $category->name);
            return $view;
        }
    }

    public function product() {
        if ($view = parent::product()) {
            $data = $view->getData();
            $product = $data['product'];
            $category = $data['category'];
            $view->with('currentCateId', $category->id)
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
