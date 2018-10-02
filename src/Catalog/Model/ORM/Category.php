<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class Category extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;

    protected static $RelationModels = [
        'description' => [
            'class' => CategoryDescription::class,
            'foreignKey' =>'category_id'
        ]
    ];
    use Traits\TraitDescriptionHelper;

    public function getCategoryIdentifierName() {
        return 'id';
    }
    
    public function childrenCategories() {
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
}