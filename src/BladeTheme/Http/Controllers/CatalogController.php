<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class CatalogController extends Controller
{
    use TraitThemeRouteOverwritable;
    protected $allCategories;

    public function categoryProducts() {
        if ($category_id = Route::input('id')) {
            if ($category = \Zento\Catalog\Model\ORM\Category::thinMode()->find($category_id)) {
                $request = Request::instance();
                $path =  $request->path();
                $query = Str::after($request->getRequestUri(), $request->path());
                $catalog_search_uri = BladeTheme::apiUrl(sprintf('catalog/search/categories/%s', $category_id));
                $resp = BladeTheme::requestInnerApi('GET', 
                    sprintf('%s/%s', $catalog_search_uri, $query)
                );
                $pagination = $resp->success && is_object($resp->data) ? $resp->data->toArray() : $resp->data;

                $page_data = ['type' => 'category', 
                    'title' => $category->name, 
                    'description' => $category->description,
                    'catalog_search_uri' => $catalog_search_uri];
                foreach($category->parents as $parent) {
                    if ($parent->id > 2) {
                        BladeTheme::breadcrumb(BladeTheme::getCategoryUrl($parent), $parent->name);
                    }
                } 
                BladeTheme::breadcrumb(BladeTheme::getCategoryUrl($category), $category->name);
                return BladeTheme::view('page.searchresult', compact('pagination', 'path', 'page_data'));
            }
        }
        return view('page.404');
    }

    public function product() {
        if ($productId = Route::input('id')) {
            $resp = BladeTheme::requestInnerApi('GET', 
                BladeTheme::apiUrl(sprintf('catalog/products/%s', $productId))
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

                $tabs = [];
                if ($collection = DynamicAttribute::whereIn('name', array_keys($product->getDynRelations()))
                    ->where('front_group', '!=', '')
                    ->whereNotNull('front_group')
                    ->select('name', 'front_label', 'front_group')
                    ->orderBy('sort')
                    ->orderBy('front_label')
                    ->get()) 
                {
                    foreach($collection as $item) {
                        $tabs[$item->front_group][] = ['label' => $item->front_label, 'attribute' => $item->name];
                    }
                }

                BladeTheme::breadcrumb(BladeTheme::getProductUrl($product), $product->name);
                return BladeTheme::view('page.product', compact('product', 'category', 'categories', 'tabs'));
            }
            return BladeTheme::view('page.404');
        }
    }

    protected function fetchAllCategories() {
        if (!$this->allCategories) {
            $resp = BladeTheme::requestInnerApi('GET', BladeTheme::apiUrl('catalog/categories/tree'));
            $this->allCategories = $resp->success ? $resp->data : null;
        }
        return $this->allCategories;
    }

    protected function fetchCategories($category_ids) {
        $resp = BladeTheme::requestInnerApi('GET', 
            BladeTheme::apiUrl(sprintf('catalog/categories/%s', $category_ids)));
        if ($succeed) {
            return $resp->data;
        }
    }

    public function search() {
        $request = Request::instance();
        $query = Str::after($request->getRequestUri(), $request->path());
        $path = $request->path();
        $resp = BladeTheme::requestInnerApi('GET', 
            BladeTheme::apiUrl(sprintf('catalog/search%s', $query))
        );
        $pagination = $resp->success ? $resp->data->toArray() : $resp->data;
        $page_data = [
            'type' => 'search', 
            'catalog_search_uri' => "/api/v1/catalog/search",
            'title' => sprintf('Search Result for: "%s"', $pagination['criteria']['text'] ?? ''),
            'description' => '',
        ];
        return BladeTheme::view('page.searchresult', compact('pagination', 'path', 'page_data'));
    }
}
