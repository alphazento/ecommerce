<?php

namespace Zento\Catalog\Model\ORM;

use Zento\Catalog\Model\HasManyInAggregatedField;

class Category extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Category
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;
 
    public static function getPreloadRelations() {
        return [
            'category_description' =>[
                'description', 'name', 'meta_title', 'meta_description', 'meta_keyword'
            ],
            'children',
            'withcount' => ['products']
        ];
    }

    public function category_description() {
        return $this->hasOne(CategoryDescription::class, 'category_id');
    }

    public function children() {
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