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
        if ($category_id = Route::input('id')) {
            return $this->categoryProducts($category_id);
        }
    }

    protected function categoryProducts($category_id) {
        $pageData = [];
        if ($resp = BladeTheme::innerApiProxy('GET', 
            sprintf('/api/v1/categories/%s/products?%s', $category_id, Request::getQueryString()))
            ) {
            $pageData = $resp['data'];
        }
        return BladeTheme::view('page.productlist', compact('category_id', 'pageData'));
    }

    public function product() {
        if ($productId = Route::input('id')) {
            if ($resp = BladeTheme::innerApiProxy('GET',
                $this->genApiUrl(sprintf('products/%s', $productId)))
            ) {
                $product = $resp['data'];
                $categories = [];
                if ($category_ids = Route::input('category_ids')) {
                    if ($categories = $this->fetchCategories()) {
                        foreach($categories as $category) {
                            BladeTheme::breadcrumb(BladeTheme::getCategoryUrl($category), $category->name);
                        }
                    }
                    $category = $categories[0];
                } else {
                    $category = $product->categories[0] ?? false;
                }
                BladeTheme::breadcrumb(BladeTheme::getProductUrl($product), $product->name);
                return BladeTheme::view('page.product', compact('product', 'category', 'categories'));
            }
            return BladeTheme::view('page.404');
        }
    }

    protected function fetchAllCategories() {
        if (!$this->allCategories) {
            if ($resp = BladeTheme::innerApiProxy('GET', '/api/v1/categories')) {
                $this->allCategories = $resp['data'];
            } else {
                $this->allCategories = null;
            }
        }
        return $this->allCategories;
    }

    protected function fetchCategories($category_ids) {
        if ($resp = BladeTheme::innerApiProxy('GET',
            $this->genApiUrl(sprintf('categories/%s', $category_ids)))
        ) {
            if ($resp['status'] == 200) {
                return $resp['data'];
            }
        }
    }
}
