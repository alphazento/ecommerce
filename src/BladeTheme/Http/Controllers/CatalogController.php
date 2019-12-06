<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    use TraitThemeRouteOverwritable;
    protected $allCategories;

    public function categoryProducts() {
        if ($category_id = Route::input('id')) {
            $resp = BladeTheme::requestInnerApi('GET', 
                $this->genApiUrl(sprintf('categories/%s/products?%s', $category_id, Request::getQueryString()))
            );
            if ($resp->success) {
                $pageData = $resp->data;
                return BladeTheme::view('page.productlist', compact('category_id', 'pageData'));
            }
        }
        return view('page.404');
    }

    public function product() {
        if ($productId = Route::input('id')) {
            $resp = BladeTheme::requestInnerApi('GET', 
                $this->genApiUrl(sprintf('products/%s', $productId))
            );
            if ($resp->success) {
                $product = $resp->data;
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
            $resp = BladeTheme::requestInnerApi('GET', $this->genApiUrl('categories/tree'));
            $this->allCategories = $resp->success ? $resp->data : null;
        }
        return $this->allCategories;
    }

    protected function fetchCategories($category_ids) {
        $resp = BladeTheme::requestInnerApi('GET', 
            $this->genApiUrl(sprintf('categories/%s', $category_ids)));
        if ($succeed) {
            return $resp->data;
        }
    }

    public function search() {
        $request = Request::instance();
        $query = Str::after($request->getRequestUri(), $request->path());
        $resp = BladeTheme::requestInnerApi('GET', 
            $this->genApiUrl(sprintf('catalog/search%s', $query))
        );
        if ($resp->success) {
            $pagination = $resp->data->toArray();
        } else {
            $pagination = $resp->data;
        }
        return BladeTheme::view('page.searchresult', compact('pagination'));
    }
}
