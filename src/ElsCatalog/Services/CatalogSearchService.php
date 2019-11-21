<?php

namespace Zento\ElsCatalog\Services;

use DB;
use Store;
use Cache;
use ShareBucket;
use Illuminate\Pagination\Paginator;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\ElsCatalog\Model\ElsIndex\Product;
use Zento\Catalog\Providers\Facades\CategoryService;

use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Pagination\LengthAwarePaginator;

class CatalogSearchService extends \Zento\CatalogSearch\Services\CatalogSearchService
{
    /**
     * the filters which match with criteria params
     *
     * @var array
     */
    protected $criteria_filters = [
        'category' => 'filterCategory',
        'sub_categories' => 'filterCategory',
        'price' => 'filterPrice',
        'text' =>'filterText',
    ];
 
    protected $sort_bys = [
        'position' => 'orderByPosition', 
        'price' => 'orderByPrice',
        'name' => 'orderByName',
    ];

    public function registerCriteriaFilter($name, $callback) {
        $this->criteria_filters[$name] = $callback;
    }

    protected function applyOrderByEavField($builder, $dyn_field, $direction) {
        $product_table = $builder->getModel()->getTable();
        if ($table = DanamicAttributeFactory::getTable($builder->getModel(), $dyn_field)) {
            $builder->join($table, $product_table . '.id', '=', $table . '.foreignkey')
                ->orderBy($table . '.value', $direction);
        }
    }

    protected function orderByPosition($builder, $field, $direction = 'asc') {
        
    }

    protected function orderByPrice($builder, $field, $direction = 'asc') {
        $builder->orderBy('price.keyword', $direction);
    }

    protected function orderByName($builder, $field, $direction = 'asc') {
        $builder->orderBy('name.keyword', $direction);
    }

    /**
     * filter category
     *
     * @param [type] $builder
     * @param array $category_ids  [id1, id2]
     * @return void
     */
    protected function filterCategory($builder, array $category_ids) {
        if (count($category_ids) > 0) {
            $builder->whereIn('category', $category_ids);
        }
    }

    protected function filterText($builder, $text) {
        if (!empty($text)) {
            $builder->whereMultiMatch(['name^3', 'sku^5', 'description'], $text, '60%')
                ->orderBy('_score', 'desc');
        }
    }

    /**
     * filter price by input price range
     *
     * @param [type] $builder
     * @param array $conditions  [['>=' => 10, '<=' => 20], ['>='=>30, '<=' => 40]]
     * @return void
     */
    protected function filterPrice($builder, array $conditionGroups) {
        if (count($conditionGroups) > 0) {
            // $table = (new ProductPrice)->getTable();
            // $this->joined_tables[$table] = true;
            // $product_table = $builder->getModel()->getTable();
            // $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            // $builder->where(function($query) use($conditionGroups, $table){
            //     foreach($conditionGroups as $group) {
            //         $query->orWhere(function($subQuery) use ($group, $table) {
            //             foreach($group as $cond => $value) {
            //                 $subQuery->where($table . '.price', $cond, $value);
            //             }
            //         });
            //     }
            // });
        }
    }

    /**
     * {
        "criteria" : {
            "category": [4],
            "price": [
                {
                    ">=":12,
                    "<=":13.5
                },
                {
                    ">=":14,
                    "<=":15
                }
            ]
        },
        "sort_by":"price,asc"
        }
     */
    public function search($criteria, $per_page, $page, $withAggregate = true) {
        // echo '<pre>';
        // print_r($criteria);
        // echo '</pre>';
        $builder = $this->applyFilter($criteria, $withAggregate);

        if (!empty($criteria['sort_by'])) {
            // $this->applyOrderBy($builder, $criteria['sort_by']);
        }
        $this->aggregate($builder, $criteria);

        $success = true;
        $code = 200;
        $data = null;
        $paginator = $builder->paginate($per_page);

        if ($paginator->lastPage() < $page && $paginator->total() > 0) {
            $code = 302;
            $paginator = $builder->paginate($per_page, ['*'], 'page', $paginator->lastPage());
        }
        
        if ($paginator->total() == 0) {
            $code = 404;
            $data = [];
        } else {
            $data = $paginator->toArray();
        }
        return compact('success', 'code', 'data');
    }

    protected function applyFilter($criteria, $withAggregate = true) {
        $builder = Product::query();
        foreach($criteria as $name => $filter) {
            if ($name == 'sort_by') { continue; }
            if ($name == 'price') { 
                $priceFilter = $filter;
                continue; 
            }
            if (isset($this->criteria_filters[$name])) {
                $callback = $this->criteria_filters[$name];
                if (is_callable($callback)) {
                    call_user_func_array($callback, [$builder, $filter]);
                } else {
                    $this->{$callback}($builder, $filter);
                }
            } else {
                $values = is_array($filter) ? $filter : [$filter];
                $builder->whereInLike($name, $values);
            }
        }

        return $builder;
    }

    protected function aggregate($builder, &$criteria) {
        $aggraegatableDAs = $this->getSearchLayerDynAttributes();
        $attrs = ['category'];
        foreach($aggraegatableDAs as $da) {
            $attrs[] = $da['attribute_name'] . '.keyword';
        }
        $builder->aggs($attrs);
    }

    protected function getSearchLayerDynAttributes() {
        $key = 'searchlayer-attribute';
        if (!ShareBucket::has($key)) {
            if (!Cache::has($key)) {
                $collection = DynamicAttribute::with(['options'])
                    ->where('parent_table', 'products')
                    ->where('enabled', 1)
                    ->where('is_search_layer', 1)
                    ->orderBy('search_layer_sort')
                    ->get();
                $ds = $collection->toArray();
                ShareBucket::put($key, $ds);
                Cache::forever($key, $ds);
                return $ds;
            }
            ShareBucket::put($key, Cache::get($key));
        }
        return ShareBucket::get($key);
    }

    protected function applyOrderBy($builder, $order_by) {
        list($order_by_field, $dir) = explode(',', $order_by);
        // $builder->orderBy($order_by_field, $dir);
    }
}