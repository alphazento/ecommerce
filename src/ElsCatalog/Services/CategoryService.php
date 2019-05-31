<?php

namespace Zento\ElsCatalog\Services;

use Illuminate\Database\Eloquent\Model;

class CategoryService extends \Zento\Catalog\Services\CategoryService 
{
    protected $model = \Zento\ElsCatalog\Model\ElsIndex\Category::class;

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
            $builder->where('is_active', '=', 1);
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
                $builder->where('is_active', '=', 1);
            }
            $this->cache[$cacheKey] = $builder->orderBy('sort_by')->get();
        }
        return $this->cache[$cacheKey];
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
}