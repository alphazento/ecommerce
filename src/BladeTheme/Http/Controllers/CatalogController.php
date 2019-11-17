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

    public function categoryProducts() {
        if ($category_id = Route::input('id')) {
            $pageData = [];
            list($succeed, $pageData, $rawData) = BladeTheme::requestInnerApi('GET', 
            $this->genApiUrl(sprintf('categories/%s/products?%s', $category_id, Request::getQueryString()))
            );
            if ($succeed) {
                return BladeTheme::view('page.productlist', compact('category_id', 'pageData'));
            }
        }
        return view('page.404');
    }

    public function product() {
        if ($productId = Route::input('id')) {
            list($succeed, $product, $rawData) = BladeTheme::requestInnerApi('GET', 
                $this->genApiUrl(sprintf('products/%s', $productId))
            );
            if ($succeed) {
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
            list($succeed, $categories, $rawData) = BladeTheme::requestInnerApi('GET', $this->genApiUrl('categories/tree'));
            $this->allCategories = $succeed ? $categories : null;
        }
        return $this->allCategories;
    }

    protected function fetchCategories($category_ids) {
        list($succeed, $categories, $rawData) = BladeTheme::requestInnerApi('GET', 
            $this->genApiUrl(sprintf('categories/%s', $category_ids)));
        if ($succeed) {
            return $categories;
        }
    }
}
