<?php

namespace Zento\Catalog\Services;

use Illuminate\Database\Eloquent\Model;

class CategoryService implements \Zento\Contracts\Catalog\Service\CategoryServiceInterface 
{
    protected $rootId;
    protected $treeLevelFrom;
    protected $treeMaxLevel;

    protected $cache = [];

    protected $model = \Zento\Catalog\Model\ORM\Category::class;

    public function __construct() {
        $this->rootId = config('category.tree.root.id', 1);
        $this->treeLevelFrom = config('category.tree.level.from', 2);
        $this->treeMaxLevel = config('category.tree.level.max', 3);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Zento\Contracts\Catalog\Model\Category|null
     */
    public function getCategoryById($identifier)
    {
        $model = $this->model;
        return $model::where('id', $identifier)
            ->first();
    }

    public function getCategoryByIds(array $identifiers)
    {
        $model = $this->model;
        return $model::whereIn('id', $identifiers)->get();
    }

    /**
     * give category ids, build their category tree relationship
     */
    public function buildCategoryTreeByIds(array $identifiers, $activeOnly = true) {
        $model = $this->model;
        $builder = $model::whereIn('id', $identifiers);
        if ($activeOnly) {
            $builder->active($activeOnly);
        }
        $categories = $builder->get()->keyBy('id');
        foreach($categories ?? [] as $key => $category) {
        }
    }

    /**
     * give category ids, return all category ids including their children
     *
     * @param array $identifiers
     * @param boolean $activeOnly
     * @return array
     */
    public function getCategoryIdsWithChildrenByIds(array $identifiers, $activeOnly = true) {
        $model = $this->model;
        $builder = $model::whereIn('id', $identifiers);
        if ($activeOnly) {
            $builder->active($activeOnly);
        }
        $categories = $builder->get();
        $ids = [];
        foreach($categories ?? [] as $category) {
            $this->getCategoryIdsInCategory($category, $ids);
        }
        return $ids;
    }

    protected function getCategoryIdsInCategory(Model $category, array &$ids) {
        $ids[] = $category->id;
        foreach($category->children ?? [] as $item) {
            $this->getCategoryIdsInCategory($item, $ids);
        } 
    }

    /**
     * 
     *
     * @param integer $level
     * @param boolean $activeOnly
     * @param integer $parent_id
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getCategoriesByLevel($level, $activeOnly = true, $parent_id = -1) {
        $model = $this->model;
        $cacheKey = sprintf('%s.all.%s', $level, $parent_id);
        if (!isset($this->cache[$cacheKey])) {
            $builder = $model::where('level', $level);
            if ($activeOnly) {
                $builder->active($activeOnly);
            }
            $this->cache[$cacheKey] = $builder->orderBy('sort_by')->get();
        }
        return $this->cache[$cacheKey];
    }

    /**
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Zento\Contracts\Catalog\Model\Category|null
     */
    public function root() {
        return $this->getCategoryById(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function tree($activeOnly = true) {
        static $tree = 0;
		if (!$tree) {
			$tree = $this->getCategoriesByLevel($this->treeLevelFrom, $activeOnly);
		}
		return $tree;
    }
    
    /**
     * get a category's name
     *
     * @param \Zento\Contracts\Catalog\Model\Category $category
     * @param boolean $withProductCount
     * @return string
     */
    public function getName(\Zento\Contracts\Catalog\Model\Category $category, $withProductCount = false) {
        return $category->name . ($withProductCount ? sprintf('(%s)', $category->products_count) : '');
    }
    
    public function __call($method, $args) {
        $model = $this->model;
        return $model::{$method}(...$args);
    }
}