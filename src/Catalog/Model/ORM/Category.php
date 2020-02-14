<?php

namespace Zento\Catalog\Model\ORM;

use Zento\Catalog\Model\HasManyInAggregatedField;
use Zento\Contracts\Interfaces\Catalog\ICategory;

class Category extends \Illuminate\Database\Eloquent\Model implements ICategory
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
 
    protected $fillable = [
        'name',
        'attribute_set_id',
        'parent_id',
        'path',
        'position',
        'level',
        'children_count',
        'is_active',
        'sort_by'
    ];

    public $_richData_ = [
        'children'
    ];

    public function getTableFields() {
        return $this->fillable;
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
     * Scope a query to only include active.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, $activeOnly = true)
    {
        return $query->whereIn('is_active', $activeOnly ? [1]:[0,1]);
    }

    public function getUrlAttribute() {
        return sprintf('/%s.html', $this->url_key);
    }
}
