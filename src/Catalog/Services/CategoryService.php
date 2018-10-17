<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class CategoryService implements \Zento\Contracts\Catalog\Service\CategoryServiceInterface 
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
     * @return \Zento\Contracts\Catalog\Model\Category|null
     */
    public function getCategoryById($identifier)
    {
        return Category::where('id', $identifier)
            ->first();
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
        $cacheKey = sprintf('%s.all.%s', $level, $parent_id);
        if (!isset($this->cache[$cacheKey])) {
            $this->cache[$cacheKey] = Category::where('level', $level)
                ->active($activeOnly)
                ->orderBy('sort_by')
                ->get();
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
    public function tree() {
		static $tree = 0;
		if (!$tree) {
			$tree = $this->getCategoriesByLevel($this->treeLevelFrom);
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
        return Category::{$method}(...$args);
    }
}