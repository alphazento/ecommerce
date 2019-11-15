<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    use TraitThemeRouteOverwritable;
    protected $allCategories;

    public function category() {
        if ($currentCateId = Route::input('id')) {
            return $this->_categories($currentCateId);
        }
    }

    protected function _categories($currentCateId) {
        $categories = $this->fetchCategories();
        $pageData = [];
        if ($resp = BladeTheme::innerApiProxy('GET', 
            sprintf('/api/v1/categories/%s/products?%s', $currentCateId, Request::getQueryString()))
            ) {
            $pageData = $resp['data'];
        }
        return BladeTheme::view('page.productlist', compact('categories', 'currentCateId', 'pageData'));
    }

    public function products() {
        if ($productId = Route::input('id')) {
            if ($resp = BladeTheme::innerApiProxy('GET', 
                sprintf('/api/v1/products/%s', $productId))
                ) {
                $product = $resp['data'];
                return BladeTheme::view('page.product', compact('product'));
            }
            return BladeTheme::view('page.404');
        }
    }

    public function fetchCategories() {
        if (!$this->allCategories) {
            if ($resp = BladeTheme::innerApiProxy('GET', '/api/v1/categories')) {
                $this->allCategories = $resp['data'];
            } else {
                $this->allCategories = null;
            }
        }
        return $this->allCategories;
    }
}
