<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    protected $allCategories;

    public function categories() {
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
        return view('page.productlist', compact('categories', 'currentCateId', 'pageData'));
    }

    public function products() {
        $categories = $this->fetchCategories();
        return view('page.productlist', compact('categories'));
    }

    public function product() {
        if ($productId = Route::input('id')) {
            if ($resp = BladeTheme::innerApiProxy('GET', 
                sprintf('/api/v1/products/%s', $productId))
                ) {
                $product = $resp['data'];
                return view('page.product', compact('product'));
            }
            return view('page.404');
        }
    }

    protected function fetchCategories() {
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
