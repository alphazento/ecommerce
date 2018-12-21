<?php

namespace Zento\Catalog\Services;

use DB;
use Store;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\CategoryProduct;
use Zento\Catalog\Model\ORM\ProductPrice;

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
            $this->joined_tables[$table] = 1;
        }
        $builder->orderBy($table . '.position', $direction);
    }

    protected function orderByPrice($builder, $field, $direction = 'asc') {
        $table = (new ProductPrice)->getTable();
        if (!isset($this->joined_tables[$table])) {
            $product_table = $builder->getModel()->getTable();
            $builder->join($table, $product_table . '.id', '=', $table . '.product_id')
                ->orderBy($table . '.price', $direction);
            $this->joined_tables[$table] = 1;
        }
        $builder->orderBy($table . '.price', $direction);
    }

    protected function orderByName($builder, $field, $direction = 'asc') {
        $builder->orderBy($product_table . '.name', $direction);
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
            $this->joined_tables[$table] = 1;
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
            $this->joined_tables[$table] = 1;
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
    public function search($filters, $order_by='position,desc') {
        $builder = (new Product)->newQuery();
        foreach($filters as $name => $filter) {
            if (isset($this->filters[$name])) {
                $callback = $this->filters[$name];
                if (is_callable($callback)) {
                    call_user_func_array($callback, [$builder, $filter]);
                } else {
                    $this->{$callback}($builder, $filter);
                }
            } 
            // else filter by eav
        }
        $this->aggregate($builder);

        if (!empty($order_by)) {
            $this->applyOrderBy($builder, $order_by);
        }

        
        dd($builder->get());
        return $builder->get();
    }

    /**
     * brand, price, category, country, new selection ... 
     */
    protected function aggregate($builder) {
        $query = clone $builder;
        $query->select(['category_products.category_id', DB::raw('count(*) as amount')]);
        $query->groupBy('category_products.category_id')->get();
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