<?php

namespace Zento\VueDesktopTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Category;

class ThemeController extends \Zento\BladeTheme\Http\Controllers\CatalogController
{
    public function categories() {
        if ($view = parent::categories()) {
            $data = $view->getData();
            $category = $data['pageData']['category'];
            BladeTheme::breadcrumb(url(BladeTheme::getCategoryUrl($category)), $category->name);
            $data['apiUrl'] = sprintf('/api/v1/categories/%s/products', Route::input('id'));
            return $view;
        }
    }

    public function product() {
        if ($view = parent::product()) {
            $data = $view->getData();
            $categories = $this->fetchCategories();
            $product = $data['product'];
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

    public function products() {
        if ($categories = $this->fetchCategories()) {
            $view = $this->_categories($categories[0]->id);
            $data = $view->getData();
            // $data['apiUrl'] = sprintf('/api/v1/categories/%s/products', Route::input('id'));
            return $view->with('apiUrl', sprintf('/api/v1/categories/%s/products', Route::input('id')));
        }
    }

    public function home() {
        // $categories = $this->fetchCategories();
        $products = Product::limit(8)->get();
        return view('page.index', compact('products'));
    }

    public function news() {
        return BladeTheme::breadcrumb(route('get.news'), 'News')
            ->view('page.news');
    }

    public function about() {
        return BladeTheme::breadcrumb(route('get.about'), '公司簡介')
            ->view('page.about');
    }

    public function news_c() {
        return view('news_c');
    }
  
    function contact() {
        return BladeTheme::breadcrumb('/contact', 'Contact Us')
            ->view('page.contact');
    }

    function cooperation() {
        return BladeTheme::breadcrumb('/cooperation', 'Cooperation')
            ->view('page.cooperation');
    }
}
