<?php

namespace Zento\CatalogSearch\Services;

use Cache;
use Closure;
use DB;
use ShareBucket;
use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\ORM\Category\CategoryProductLink;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\Product\ProductPrice;
use Zento\Catalog\Providers\Facades\CategoryService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Pagination\LengthAwarePaginator;
use Zento\Kernel\Facades\DanamicAttributeFactory;

class CatalogSearchService
{
    protected $joined_tables = [];

    /**
     * the filters which will apply to search even not include in search criteria
     *
     * @var array
     */
    protected $default_filters = [];

    protected $postSearchHandlers = [];

    protected $under_categorId = 0;

    /**
     * the filters which match with criteria params
     *
     * @var array
     */
    protected $criteria_filters = [
        'under_categorId' => 'filterCategory',
        'category' => 'filterCategory',
        'sub_categories' => 'filterCategory',
        'price' => 'filterPrice',
        'text' => 'filterText',
        'name' => 'filterText',
    ];

    protected $sort_bys = [
        'position' => 'orderByPosition',
        'price' => 'orderByPrice',
        'name' => 'orderByName',
    ];

    protected $categoryProductTable;
    public function __construct()
    {
        $this->categoryProductTable = (new CategoryProductLink)->getTable();
    }

    public function registerCriteriaFilter(string $name, Closure $callback)
    {
        $this->criteria_filters[$name] = $callback;
        return $this;
    }

    public function registerDefaultFilterLayer(Closure $callback)
    {
        $this->default_filters[] = $callback;
        return $this;
    }

    public function registerSortBy(string $name, Closure $callback)
    {
        $this->sort_bys[$name] = $callback;
        return $this;
    }

    public function registerPostSearchHandler(Closure $callback)
    {
        $this->postSearchHandlers[] = $callback;
        return $this;
    }

    protected function applyOrderByEavField($builder, $dyn_field, $direction)
    {
        $product_table = $builder->getModel()->getTable();
        if ($table = DanamicAttributeFactory::getTable($builder->getModel(), $dyn_field)) {
            $builder->join($table, $product_table . '.id', '=', $table . '.foreignkey')
                ->orderBy($table . '.value', $direction);
        }
    }

    protected function orderByPosition($builder, $field, $direction = 'asc')
    {
        $product_table = $builder->getModel()->getTable();
        $productPositions = DB::table($this->categoryProductTable)
            ->select('product_id', 'position')
            ->distinct();
        $builder->joinSub($productPositions, 'productPositions', function ($join) use ($product_table) {
            $join->on($product_table . '.id', '=', 'productPositions.product_id');
        });
        $builder->orderBy('productPositions.position', $direction);
        return 'productPositions.position';
    }

    protected function orderByPrice($builder, $field, $direction = 'asc')
    {
        $table = (new ProductPrice)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $this->joined_tables[$table] = true;
        }
        $builder->orderBy($table . '.price', $direction);
        return $table . '.price';
    }

    protected function orderByName($builder, $field, $direction = 'asc')
    {
        $builder->orderBy('name', $direction);
        return 'name';
    }

    /**
     * filter category
     *
     * @param [type] $builder
     * @param array $category_ids  [id1, id2]
     * @return void
     */
    protected function filterCategory($builder, array $category_ids)
    {
        if (count($category_ids) > 0) {
            $product_table = $builder->getModel()->getTable();
            if (!isset($this->joined_tables[$this->categoryProductTable])) {
                $this->joined_tables[$this->categoryProductTable] = true;
                $builder->join($this->categoryProductTable, $product_table . '.id', '=', $this->categoryProductTable . '.product_id');
            }
            // $ids = CategoryService::getCategoryIdsWithChildrenByIds($category_ids);
            $ids = $category_ids;
            $builder->whereIn($this->categoryProductTable . '.category_id', $ids);
        }
    }

    protected function filterText($builder, $text)
    {
        if (!empty($text)) {
            $engine = new \Zento\CatalogSearch\Model\FullTextSearchEngine();
            $ids = $engine->search($text);
            $product_table = $builder->getModel()->getTable();
            $builder->whereIn($product_table . '.id', $ids);
        }
    }

    /**
     * filter price by input price range
     *
     * @param [type] $builder
     * @param array $conditions  [10, 20]
     * @return void
     */
    protected function filterPrice($builder, array $conditions)
    {
        if (count($conditions) > 0) {
            $table = (new ProductPrice)->getTable();
            $this->joined_tables[$table] = true;
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id');
            $builder->where(function ($query) use ($conditions, $table) {
                sort($conditions);
                if ($conditions[0] ?? false) {
                    $query->where($table . '.price', '>=', $conditions[0]);
                }
                if ($conditions[0] ?? false) {
                    $query->where($table . '.price', '<=', $conditions[1]);
                }
            });
        }
    }

    /**
     * {
    "criteria" : {
    "category": [4],
    "price": [0, 100]
    },
    "sort_by":"price,asc"
    }
     */
    public function search($under_categorId, $criteria, $per_page, $page, $withAggregate = true)
    {
        if ($under_categorId) {
            $this->under_categorId = $under_categorId;
            $criteria['under_categorId'] = CategoryService::getCategoryIdsWithChildrenByIds([$under_categorId]);
        }
        list($builder, $aggregateQuery) = $this->applyFilter($criteria, $withAggregate);

        if (!empty($criteria['sort_by'])) {
            $this->applyOrderBy($builder, $criteria['sort_by']);
        }

        $success = true;
        $code = 200;
        $paginator = $builder->distinctPaginate('products.id', $per_page);
        // $paginator = $builder->paginate($per_page);

        if ($paginator->lastPage() < $page && $paginator->total() > 0) {
            $code = 302;
            $paginator = $builder->paginate($per_page, ['*'], 'page', $paginator->lastPage());
        }
        if ($paginator->total() == 0) {
            $success = false;
            $code = 404;
            $data = compact('criteria');
        } else {
            $aggregate = $withAggregate ? $this->aggregate($aggregateQuery, $criteria) : [];
            foreach ($this->postSearchHandlers as $handler) {
                $handler($paginator->items());
            }
            $data = LengthAwarePaginator::fromPaginator(
                $paginator,
                compact('aggregate', 'criteria')
            );
        }

        return compact('success', 'code', 'data');
    }

    protected function applyFilter($criteria, $withAggregate = true)
    {
        $model = new Product;
        $product_table = $model->getTable();
        $fields = $model->getTableFields();
        $fields[] = 'id';
        $fields = array_map(function ($field) use ($product_table) {
            return $product_table . '.' . $field;
        }, $fields);
        //select must include morph_type for mutiple product type
        $builder = $model->newQuery()->select($fields);
        $priceFilter = null; // price's aggregate is special

        //apply extra filter layer
        foreach ($this->default_filters as $callback) {
            if (is_callable($callback)) {
                call_user_func_array($callback, [$builder]);
            }
        }
        $builder->distinct();

        $searchLayerDynamicAttrs = $this->getSearchLayerDynAttributes();
        $dynAttrs = [];
        foreach ($searchLayerDynamicAttrs as $da) {
            $dynAttrs[] = $da['name'];
        }

        foreach ($criteria as $name => $filter) {
            if ($name == 'sort_by') {continue;}
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
                $values = $filter;
                if (!is_array($filter)) {
                    $values = [$filter];
                }
                // if (count($values) > 0 && in_array($name, $dynAttrs)) {
                if (count($values) > 0) {
                    //filter column or dynamic column
                    if (in_array($name, $dynAttrs)) {
                        $builder->whereIn($name, $values);
                    } else {
                        if (is_array($filter)) {
                            $builder->whereIn($name, $filter);
                        } else {
                            $builder->whereIn($name, [$filter]);
                        }
                    }
                }
            }
        }

        $aggregateQuery = $withAggregate ? (clone $builder) : null;

        if ($priceFilter) {
            $this->filterPrice($builder, $priceFilter);
        }

        return [$builder, $aggregateQuery];
    }

    protected function aggregate($builder, &$criteria)
    {
        $builder->thinMode();
        $priceItems = $this->aggregatePrice($builder, $criteria);
        $aggregation = [
            'price' => [
                'filter' => 'price',
                'is_dynattr' => false,
                'label' => 'Price',
                'applied' => [],
                'items' => $priceItems,
            ],
        ];
        list($cateFilters, $categoryItems) = $this->aggregateCategory($builder, $criteria);
        if (count($cateFilters) || $categoryItems->count()) {
            $aggregation['category'] = [
                'filter' => 'category',
                'is_dynattr' => false,
                'label' => 'Category',
                'applied' => $cateFilters,
                'items' => $categoryItems,
            ];
        }
        $this->aggregateDynamicAttributes($builder, $aggregation, $criteria);
        $builder->richMode();
        return $aggregation;
    }

    /**
     * brand, price, category, country, new selection ...
     */
    protected function aggregateCategory($builder, &$criteria)
    {
        //category aggregate
        $searchInCategoryIds = array_merge($criteria['category'] ?? [], $criteria['sub_category'] ?? []);
        $query = clone $builder;
        $product_table = $builder->getModel()->getTable();
        if (!isset($this->joined_tables[$this->categoryProductTable])) {
            $query->join($this->categoryProductTable, $product_table . '.id', '=', $this->categoryProductTable . '.product_id');
        }
        $query->whereNotIn($this->categoryProductTable . '.category_id', $searchInCategoryIds)
            ->select([$this->categoryProductTable . '.category_id', DB::raw('count(*) as amount')]);
        $agg = $query->groupBy($this->categoryProductTable . '.category_id')->get();

        $items = $agg->keyBy('category_id');
        $categories = Category::whereIn('id', $items->keys()->toArray())
            ->where('id', '!=', $this->under_categorId)
            ->get();

        $aggregates = $categories->map(function ($category) use ($items) {
            $item = $items[$category->id];
            return ['id' => $category->id, 'label' => ($category->name ?? ''), 'amount' => $item['amount']];
        });

        $filters = array_map(function ($id) {
            $category = Category::find($id);
            return ['id' => $id, 'label' => ($category->name ?? '')];
        }, $searchInCategoryIds
        );
        // $criteriaCategory = isset($criteria['category']) ? $criteria['category']:[];
        // if (count($criteriaCategory) >0) {
        //     $ret = $ret->filter(function($item) use(&$criteriaCategory){
        //         return !in_array($item['id'], $criteriaCategory);
        //     });
        // }
        return [$filters, $aggregates];
    }

    protected function getSearchLayerDynAttributes()
    {
        $key = 'searchlayer-attribute';
        if (!ShareBucket::has($key)) {
            if (!Cache::has($key)) {
                $collection = DynamicAttribute::with(['options'])
                    ->where('parent_table', 'products')
                    ->where('active', 1)
                    ->where('searchable', 1)
                    ->orderBy('sort')
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
    protected function aggregateDynamicAttributes($builder, &$aggregation, &$criteria)
    {
        $aggraegatableDAs = $this->getSearchLayerDynAttributes();

        $product_table = $builder->getModel()->getTable();
        foreach ($aggraegatableDAs as $da) {
            $query = clone $builder;
            $table = $da['attribute_table'];
            $attr_name = $da['name'];
            $query->depressDynAttrCondition($attr_name);
            if (!isset($this->joined_tables[$table])) {
                $query->join($table, $product_table . '.id', '=', $table . '.foreignkey');
            }
            $query->select([DB::raw($table . '.value as ' . $attr_name), $product_table . '.id']);
            $agg = $builder->getConnection()
                ->table(DB::raw("({$query->toSql()}) as sub"))
                ->mergeBindings($query->getQuery())
                ->select([$attr_name, DB::raw('count(*) as amount')])
                ->groupBy($attr_name)
                ->get();

            $items = [];
            if (count($agg) > 0) {
                if ($da['with_value_map']) {
                    $attrDesc = DanamicAttributeFactory::getAttributeDesc($table);
                    $items = $agg->map(function ($row) use ($attr_name, $attrDesc) {
                        return [
                            'id' => $row->{$attr_name},
                            'value' => $attrDesc['options'][$row->{$attr_name}],
                            'amount' => $row->amount,
                        ];
                    });
                } else {
                    $items = $agg->map(function ($row) use ($attr_name) {
                        return [
                            'value' => $row->{$attr_name},
                            'amount' => $row->amount,
                        ];
                    });
                }
            }
            if (count($items)) {
                $applied = $criteria[$attr_name] ?? [];
                $aggregation[$attr_name] = [
                    'filter' => $attr_name,
                    'is_dynattr' => true,
                    'label' => empty($da['front_label']) ? $attr_name : $da['front_label'],
                    'items' => $items,
                    'applied' => $applied,
                ];
            }

        }
    }

    /**
     * brand, price, category, country, new selection ...
     */
    protected function aggregatePrice($builder, &$criteria)
    {
        //category aggregate
        $query = clone $builder;

        $table = (new ProductPrice)->getTable();
        $product_table = $query->getModel()->getTable();
        $query->leftJoin($table, $product_table . '.id', '=', $table . '.product_id');
        $columnName = $table . '.final_price';
        $query->addSelect($columnName);

        $minQuery = clone $query;
        $min = $minQuery->orderBy($columnName)->pureExec('first');
        $minValue = floor($min->final_price ?? 0);

        $maxQuery = clone $query;
        $max = $maxQuery->orderBy($columnName, 'desc')->pureExec('first');
        $maxValue = ceil($max->final_price ?? 99999);

        return [$minValue, $maxValue];
    }

    protected function applyOrderBy($builder, $order_by)
    {
        list($order_by_field, $dir) = explode(',', $order_by);
        if (isset($this->sort_bys[$order_by_field])) {
            $callback = $this->sort_bys[$order_by_field];
            if (is_callable($callback)) {
                $field = call_user_func_array($callback, [$builder, $order_by_field, $dir]);
            } else {
                $field = $this->{$callback}($builder, $order_by_field, $dir);
            }
            if ($field && is_string($field)) {
                $builder->addSelect($field);
            }
        } else {
            $dynAttrs = DanamicAttributeFactory::getAttributeDesc('products');
            foreach ($dynAttrs as $attr) {
                if ($attr->name === $order_by_field) {
                    $this->applyOrderByEavField($builder, $order_by_field, $dir);
                    return;
                }
            }
            $builder->orderBy($order_by_field, $dir);
        }
    }
}
