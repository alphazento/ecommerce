<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class EloquentCategoryProvider implements \Zento\Contracts\Catalog\Service\CategoryProviderInterface 
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
		static $tree = 0;
		if (!$tree) {
			$tree = $this->getCategoriesByLevel($this->treeLevelFrom);
		}
		return $tree;
    }
    
    public function getName($category, $withProductCount = false) {
        return $category->name . ($withProductCount ? sprintf('(%s)', $category->products_count) : '');
    }
}