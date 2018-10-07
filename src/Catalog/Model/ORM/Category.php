<?php

namespace Zento\Catalog\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class Category extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
 
    protected $desciptionModel = CategoryDescription::class;
    protected $desciptionModelForeignKey = 'category_id';
    public $preload_relations = [
        'descriptionDataset',
        'childrenCategories'
    ];

    public $preload_relation_withcounts = [
        'products',
    ];
   

    public function getIdentifierName() {
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

    public function tree() {
		$categories = $this->getCategoriesByLevel($this->rootLevel);
		foreach ($categories as $category) {
			$children_data = $this->loadChildren($category);
			$data['categories'][] = array(
				'category_id' => $category->id,
				'name' => $category->name . (config('config_product_count', true) ? ' (' . $category->products_count. ')' : ''),
				'children'    => $children_data,
				'href'        => $category->url_path,
				// 'filter_data' => $filter_data
			);
		}
		$extraData['categories'] = $data['categories'];
	}

	protected function loadChildren($category) {
		$children_data = [];
		$children = $category->childrenCategories;
		foreach($children as $child) {
			// $filter_data = array('filter_category_id' => $child->id, 'filter_sub_category' => true);

			$item = [
				'category_id' => $child->id,
				'name' => $child->name . (config('config_product_count', true) ? ' (' . $child->products_count. ')' : ''),
				'href' => $child->url_path,
				// 'filter_data' => $filter_data
			];
			if ($child->childrenCategories && $child->childrenCategories->count() > 0) {
				$item['children'] = $this->loadChildren($child);
			}
			$children_data[] = $item;
		}
		return $children_data;
	}
}