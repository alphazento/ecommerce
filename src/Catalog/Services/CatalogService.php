<?php

namespace Zento\Catalog\Services;

use DB;
use Store;
use Cache;
use ShareBucket;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\CategoryProduct;
use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductDescription;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class CatalogService
{
    protected $joined_tables = [];

    /**
     * the filters which will apply to search even not include in search criteria
     *
     * @var array
     */
    protected $extra_filters = [];

    /**
     * the filters which match with criteria params
     *
     * @var array
     */
    protected $criteria_filters = [
        'category' => 'filterCategory',
        'price' => 'filterPrice',
        'text' =>''
    ];
 
    protected $sort_bys = [
        'position' => 'orderByPosition', 
        'price' => 'orderByPrice',
        'name' => 'orderByName',
    ];

    public function registerCriteriaFilter($name, $callback) {
        $this->criteria_filters[$name] = $callback;
    }

    public function registerFilterLayer($callback) {
        $this->extra_filters[] = $callback;
    }

    public function registerSortBy($name, $callback) {
        $this->sort_bys[$name] = $callback;
    }

    // /**
    //  * get product dyn columns which support order by
    //  *
    //  * @param [type] $field
    //  * @return void
    //  */
    // public function getProductDynColOrderBys($field) {
        
    // }
 
    protected function applyOrderByEavField($builder, $dyn_field, $direction) {
        $product_table = $builder->getModel()->getTable();
        if ($table = DanamicAttributeFactory::getTable($builder->getModel(), $dyn_field)) {
            $builder->join($table, $product_table . '.id', '=', $table . '.foreignkey')
                ->orderBy($table . '.value', $direction);
        }
    }

    protected function orderByPosition($builder, $field, $direction = 'asc') {
        $table = (new CategoryProduct)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $this->joined_tables[$table] = true;
        }
        $builder->orderBy($table . '.position', $direction);
    }

    protected function orderByPrice($builder, $field, $direction = 'asc') {
        $table = (new ProductPrice)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $this->joined_tables[$table] = true;
        }
        $builder->orderBy($table . '.price', $direction);
    }

    protected function orderByName($builder, $field, $direction = 'asc') {
        // return;
        $table = (new ProductDescription)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $this->joined_tables[$table] = true;
        }
        $builder->orderBy($table . '.name', $direction);
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
            $table = (new CategoryProduct)->getTable();
            $this->joined_tables[$table] = true;
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id')
                ->whereIn($table . '.category_id', $category_ids);
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
            $table = (new ProductPrice)->getTable();
            $this->joined_tables[$table] = true;
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $builder->where(function($query) use($conditionGroups, $table){
                foreach($conditionGroups as $group) {
                    $query->orWhere(function($subQuery) use ($group, $table) {
                        foreach($group as $cond => $value) {
                            $subQuery->where($table . '.price', $cond, $value);
                        }
                    });
                }
            });
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
        list($builder, $aggregateQuery) = $this->applyFilter($criteria, $withAggregate);

        if (!empty($criteria['sort_by'])) {
            $this->applyOrderBy($builder, $criteria['sort_by']);
        }
        
        $statusCode = 200;
        $items = $builder->paginate($per_page);

        if ($items->lastPage() < $page && $items->total() > 0) {
            $statusCode = 301;
            $items = $builder->paginate($per_page, ['*'], 'page', $items->lastPage());
        }
        // $items = $items->toArray();
        if ($withAggregate) {
            // if ($items['total'] > $items['per_page']) {
                $aggregate = $this->aggregate($aggregateQuery);
            // } else {
            //     $aggregate = [];
            // }
        } else {
            $aggregate = [];
        }

        if ($items->total() == 0) {
            $statusCode = 404;
        }
        return ['status' => $statusCode, 'data' => ['aggregate' =>  $aggregate, 'items'=> $items]];
    }

    protected function applyFilter($criteria, $withAggregate = true) {
        $model = new Product;
        $builder = $model->newQuery()->select([$model->getTable() . '.*']);

        $priceFilter = null;  // price's aggregate is special

        //apply extra filter layer
        foreach($this->extra_filters as $callback) {
            if (is_callable($callback)) {
                call_user_func_array($callback, [$builder]);
            }
        }

        $searchLayerDynamicAttrs = $this->getSearchLayerDynAttributes();
        $dynAttrs = [];
        foreach($searchLayerDynamicAttrs as $da) {
            $dynAttrs[] = $da['attribute_name'];
        }
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
                if (count($filter) > 0 && in_array($name, $dynAttrs)) {
                    //filter column or dynamic column
                    $builder->whereIn($name, $filter);
                }
            }
        }

        $aggregateQuery = $withAggregate ? (clone $builder) : null;

        if ($priceFilter) {
            $this->filterPrice($builder, $priceFilter);
        }
        // echo $builder->toSql();die;

        return [$builder, $aggregateQuery];
    }

    protected function aggregate($builder) {
        $aggregation = [
            'price' => [
                'is_dynattr' => false,
                'label' => 'Price',
                'items' => $this->aggregatePrice($builder), 
            ],
            'category' => [
                'is_dynattr' => false,
                'label' => 'Category',
                'items' => $this->aggregateCategory($builder)
            ]
        ];
        $this->aggregateDynamicAttributes($builder, $aggregation);
        return $aggregation;
    }

    /**
     * brand, price, category, country, new selection ... 
     */
    protected function aggregateCategory($builder) {
        //category aggregate
        $query = clone $builder;
        $table = (new CategoryProduct)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
        }
        $query->select([$table . '.category_id', DB::raw('count(*) as amount')]);
        $agg = $query->groupBy($table . '.category_id')->get();

        return $agg->map(function ($item) {
            return ['id' => $item['category_id'], 'amount' => $item['amount']];
          });
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

    /**
     * brand, price, category, country, new selection ... 
     */
    protected function aggregateDynamicAttributes($builder, &$aggregation) {
        // $collection = DynamicAttribute::with(['options'])
        //     ->where('parent_table', 'products')
        //     ->where('enabled', 1)
        //     ->where('is_search_layer', 1)
        //     ->orderBy('search_layer_sort')
        //     ->get();
        $aggraegatableDAs = $this->getSearchLayerDynAttributes();

        $product_table = $builder->getModel()->getTable();
        foreach($aggraegatableDAs as $da) {
            $query = clone $builder;
            $table = $da['attribute_table'];
            $attr_name = $da['attribute_name'];
            $query->depressDynAttrCondition($attr_name);
            if (!isset($this->joined_tables[$table])) {
                $query->join($table, $product_table . '.id', '=', $table . '.foreignkey');
            }
            $query->select([DB::raw($table . '.value as ' . $attr_name), DB::raw('count(*) as amount')]);
            $agg = $query->groupBy($attr_name)->get();
            $items = [];
            if (count($agg) >0) {
                if ($da['with_value_map']) {
                    $attrDesc = DanamicAttributeFactory::getAttributeDesc($table);
                    $items = $agg->map(function ($row) use ($attr_name, $attrDesc) {
                        return [
                            'id' => $row[$attr_name], 
                            'value' => $attrDesc['options'][$row[$attr_name]], 
                            'amount' => $row['amount']
                        ];
                      });
                } else {
                    $items = $agg->map(function ($row) use ($attr_name) {
                        return [
                            'value' => $row[$attr_name], 
                            'amount' => $row['amount']
                        ];
                      });
                }
            }
            $aggregation[$attr_name] =[
                'is_dynattr' => true,
                'label' => $da['label'],
                'items' => $items
            ];
        }
    }

    /**
     * brand, price, category, country, new selection ... 
     */
    protected function aggregatePrice($builder) {
        //category aggregate
        $query = clone $builder;

        $table = (new ProductPrice)->getTable();
        $product_table = $query->getModel()->getTable();
        $query->join($table, $product_table . '.id', '=', $table . '.product_id');

        $minQuery = clone $query;
        $min = $minQuery->orderBy('price')->first();
        $minValue = $min ? floor($min->price) : 0;

        $maxQuery = clone $query;
        $max = $maxQuery->orderBy('price','desc')->first();
        $maxValue = $max ? ceil($max->price) : 999999;

        // $range = $max - $min;
        // $split = 4;
        // $avgQuery = clone $query;
        // $avg = $avgQuery->avg('price');

        return [$minValue, $maxValue];
    }

    protected function applyOrderBy($builder, $order_by) {
        list($order_by_field, $dir) = explode(',', $order_by);
        if (isset($this->sort_bys[$order_by_field])) {
            $callback = $this->sort_bys[$order_by_field];
            if (is_callable($callback)) {
                call_user_func_array($callback, [$builder, $order_by_field, $dir]);
            } else {
                $this->{$callback}($builder, $order_by_field, $dir);
            }
        } else {
            $this->applyOrderByEavField($builder, $order_by_field, $dir);
        }
    }
}