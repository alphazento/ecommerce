<?php

namespace Zento\BladeTheme\Http\Controllers;

use App\Http\Controllers\Controller;
use BladeTheme;
use Illuminate\Support\Str;
use Request;
use Route;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class CatalogController extends Controller
{
    use TraitCartHelper;
    protected $allCategories;

    /**
     * Render a specified category page
     * @group Web Pages
     */
    public function categoryProducts()
    {
        if ($category_id = Route::input('id')) {
            if ($category = \Zento\Catalog\Model\ORM\Category::thinMode()->find($category_id)) {
                $request = Request::instance();
                $path = $request->path();
                $query = Str::after($request->getRequestUri(), $request->path());
                $uri = BladeTheme::apiUrl(sprintf('catalog/search/categories/%s', $category_id));
                $resp = BladeTheme::requestInnerApi('GET',
                    sprintf('%s/%s', $uri, $query)
                );
                $pagination = $resp->success && is_object($resp->data) ? $resp->data->toArray() : $resp->data;

                $page_data = ['type' => 'category',
                    'title' => $category->name,
                    'description' => $category->description,
                    'uri' => $uri];
                foreach ($category->parents as $parent) {
                    if ($parent->id > 2) {
                        BladeTheme::breadcrumb($parent->url, $parent->name);
                    }
                }
                BladeTheme::breadcrumb($category->url, $category->name);
                return BladeTheme::view('page.searchresult', compact('pagination', 'path', 'page_data'));
            }
        }
        return view('page.404');
    }

    /**
     * Render a specified product page
     * @group Web Pages
     */
    public function product()
    {
        if ($productId = Route::input('id')) {
            $resp = BladeTheme::requestInnerApi('GET',
                BladeTheme::apiUrl(sprintf('catalog/products/%s', $productId))
            );

            if ($resp->success) {
                $product = $resp->data;
                $categories = [];
                if ($category_ids = Route::input('category_ids')) {
                    if ($categories = $this->fetchCategories()) {
                        foreach ($categories as $category) {
                            BladeTheme::breadcrumb($category->url, $category->name);
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
                    ->select('name', 'front_component', 'front_group')
                    ->orderBy('sort')
                    ->orderBy('front_component')
                    ->get()) {
                    foreach ($collection as $item) {
                        $tabs[$item->front_group][] = ['type' => $item->front_component, 'attribute' => $item->name];
                    }
                }

                BladeTheme::breadcrumb($product->url, $product->name);
                return BladeTheme::view('page.product', compact('product', 'category', 'categories', 'tabs'));
            }
            return BladeTheme::view('page.404');
        }
    }

    protected function fetchAllCategories()
    {
        if (!$this->allCategories) {
            $resp = BladeTheme::requestInnerApi('GET', BladeTheme::apiUrl('catalog/categories/tree'));
            $this->allCategories = $resp->success ? $resp->data : null;
        }
        return $this->allCategories;
    }

    protected function fetchCategories($category_ids)
    {
        $resp = BladeTheme::requestInnerApi('GET',
            BladeTheme::apiUrl(sprintf('catalog/categories/%s', $category_ids)));
        if ($succeed) {
            return $resp->data;
        }
    }

    /**
     * Render search result page
     * @group Web Pages
     */
    public function search()
    {
        $request = Request::instance();
        $query = Str::after($request->getRequestUri(), $request->path());
        $path = $request->path();
        $resp = BladeTheme::requestInnerApi('GET',
            BladeTheme::apiUrl(sprintf('catalog/search%s', $query))
        );
        $pagination = $resp->success ? $resp->data->toArray() : $resp->data;
        $page_data = [
            'type' => 'search',
            'uri' => "/api/v1/catalog/search",
            'title' => sprintf('Search Result for: "%s"', $pagination['criteria']['text'] ?? ''),
            'description' => '',
        ];
        return BladeTheme::view('page.searchresult', compact('pagination', 'path', 'page_data'));
    }
}
