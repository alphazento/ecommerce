<?php

namespace Zento\Catalog\Model\ORM;

use Zento\Catalog\Model\HasManyInAggregatedField;

class Category extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Category
{
    use Traits\ParallelCategory;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
    use Traits\TraitRealationMutatorHelper;
 
    protected static $DesciptionModel = CategoryDescription::class;
    protected static $DesciptionModelForeignKey = 'category_id';
    public static $preload_relations = [
        'description_dataset' =>[
            'description', 'name', 'meta_title', 'meta_description', 'meta_keyword'
        ],
        'children_categories',
        'withcount' => ['products']
    ];

    public function children_categories() {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('position');
    }

    /**
     * direct parent
     */
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * all parents in the path
     */
    public function parents() {
        $instance = $this->newRelatedInstance(Category::class);
        return (new HasManyInAggregatedField($instance->newQuery(), $this, $instance->getTable() . '.id',  'path'))
            ->orderBy('level')
            ->whereInAggregatedField(function($field) {
                $data = explode('/', $field);
                array_pop($data);
                return $data;
            });
    }
 
    /**
     * all its products
     */
    public function products() {
        return $this->hasManyThrough(Product::class, CategoryProduct::class, 'category_id', 'id', 'id', 'product_id');
    }
    
    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, $activeOnly = true)
    {
        return $query->whereIn('is_active', $activeOnly ? [1]:[0,1]);
    }
}