<?php

namespace Zento\Catalog\Services;

use DB;
use Store;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\CategoryProduct;
use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductDescription;

class CatalogService
{
    protected $joined_tables = [];

    protected $filters = [
        'category' => 'filterCategory',
        'price' => 'filterPrice',
        'text' =>''
    ];

    protected $sort_bys = [
        'position' => 'orderByPosition', 
        'price' => 'orderByPrice',
        'name' => 'orderByName',
    ];


    public function registerFilter($name, $callback) {
        $this->filters[$name] = $callback;
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
    public function search($criteria, $per_page, $withAggregate = true) {
        list($builder, $aggregateQuery) = $this->prepareSearch($criteria, $withAggregate);

        if (!empty($criteria['sort_by'])) {
            $this->applyOrderBy($builder, $criteria['sort_by']);
        }
        
        $items = $builder->paginate($per_page);
        $items = $items->toArray();
        if ($withAggregate) {
            // if ($items['total'] > $items['per_page']) {
                $aggregate = $this->aggregate($aggregateQuery);
            // } else {
            //     $aggregate = [];
            // }
        } else {
            $aggregate = [];
        }

        return ['aggregate' =>  $aggregate, 'items'=> $items];
    }

    protected function prepareSearch($criteria, $withAggregate = true) {
        $model = new Product;
        $builder = $model->newQuery()->select([$model->getTable() . '.*']);
        
        $priceFilter = null;  // price's aggregate is special

        foreach($criteria as $name => $filter) {
            if ($name == 'sort_by') { continue; }
            if ($name == 'price') { 
                $priceFilter = $filter;
                continue; 
            }
            if (isset($this->filters[$name])) {
                $callback = $this->filters[$name];
                if (is_callable($callback)) {
                    call_user_func_array($callback, [$builder, $filter]);
                } else {
                    $this->{$callback}($builder, $filter);
                }
            } 
        }

        $aggregateQuery = $withAggregate ? (clone $builder) : null;

        if ($priceFilter) {
            $this->filterPrice($builder, $priceFilter);
        }
        return [$builder, $aggregateQuery];
    }

    protected function aggregate($builder) {
        $aggregate = ['price' =>  $this->aggregatePrice($builder), 'category' => $this->aggregateCategory($builder)];
        if ($manufacture = $this->aggregateDynColumn($builder, 'manufacturer')) {
            $aggregate['manufacturer'] = $manufacture;
        }
        
        return $aggregate;
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
            return ['category_id' => $item['category_id'], 'amount' => $item['amount']];
          });
    }

    /**
     * brand, price, category, country, new selection ... 
     */
    protected function aggregateDynColumn($builder, $dyn_field) {
        $query = clone $builder;

        if ($table = DanamicAttributeFactory::getTable($builder->getModel(), $dyn_field)) {
            if (!isset($this->joined_tables[$table])) {
                $product_table = $query->getModel()->getTable();
                $query->join($table, $product_table . '.id', '=', $table . '.foreignkey');
            }
            $query->select([DB::raw($table . '.value as ' . $dyn_field), DB::raw('count(*) as amount')]);
            $agg = $query->groupBy($dyn_field)->get();
            return $agg->map(function ($item) use ($dyn_field) {
                return [$dyn_field => $item[$dyn_field], 'amount' => $item['amount']];
              });
        }
        return false;
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
        $minValue = floor($min->price);

        $maxQuery = clone $query;
        $max = $maxQuery->orderBy('price','desc')->first();
        $maxValue = ceil($max->price);

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