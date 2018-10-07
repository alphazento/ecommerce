<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class EloquentCategoryProvider implements \Zento\Contracts\Catalog\CategoryProvider 
{
    protected $rootId;
    protected $treeLevelFrom;
    protected $treeMaxLevel;

    protected $cache = [];

    public function __construct() {
        $this->rootId = config('category.tree.root.id', 1);
        $this->treeLevelFrom = config('category.tree.level.from', 2);
        $this->treeMaxLevel = config('category.tree.level.max', 3);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCategoryById($identifier)
    {
        return Category::where('id', $identifier)
            ->first();
    }

    public function getCategoriesByLevel($level, $activeOnly = true, $parent_id = -1) {
        $cacheKey = sprintf('%s.%s.%s', $level, $activeOnly, $parent_id);
        if (!isset($this->cache[$cacheKey])) {
            $this->cache[$cacheKey] = Category::where('level', $level)
                ->whereIn('is_active', $activeOnly ? [1]:[0,1])
                ->orderBy('sort_by')
                ->get();
        }
        return $this->cache[$cacheKey];
    }

    /**
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function root() {
        return $this->getCategoryById(1);
    }

    public function tree() {
		$categories = $this->getCategoriesByLevel($this->treeLevelFrom);
		foreach ($categories as $category) {
			$children_data = $this->loadChildren($category);
		}
		$extraData['categories'] = $data['categories'];
	}

	protected function loadChildren($category) {
		$children = $category->childrenCategories;
		foreach($children as $child) {
			if ($child->childrenCategories && $child->childrenCategories->count() > 0) {
				$this->loadChildren($child);
			}
		}
    }
    
    public function load() {
        $tree = [];
		$rootCategory = CategoryService::getCategoryById($data['category_id']);
		if (!$rootCategory) {
			throw new \Exception('category not found');
		}

		$categories = CategoryService::getCategoriesByLevel($rootCategory->level);
		foreach ($categories as $category) {
            $children_data = $this->loadChildren($category);
            $category->toArray();
			$tree[] = array(
				'category_id' => $category->id,
				'name' => $category->name . (config('config_product_count', true) ? ' (' . $category->products_count. ')' : ''),
				'children'    => $children_data,
				'href'        => $category->url_path,
				// 'filter_data' => $filter_data
			);
		}
		$extraData['categories'] = $data['categories'];
		return ['extension.module.' . $viewName, $data];
	}

	// protected function loadChildren($category) {
	// 	$children_data = [];
	// 	$children = $category->childrenCategories;
	// 	foreach($children as $child) {
	// 		// $filter_data = array('filter_category_id' => $child->id, 'filter_sub_category' => true);

	// 		$item = [
	// 			'category_id' => $child->id,
	// 			'name' => $child->name . (config('config_product_count', true) ? ' (' . $child->products_count. ')' : ''),
	// 			'href' => $child->url_path,
	// 			// 'filter_data' => $filter_data
	// 		];
	// 		if ($child->childrenCategories && $child->childrenCategories->count() > 0) {
	// 			$item['children'] = $this->loadChildren($child);
	// 		}
	// 		$children_data[] = $item;
	// 	}
	// 	return $children_data;
	// }
}