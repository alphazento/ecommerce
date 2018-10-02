<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\DB\Category\Description;
use DB;

class EloquentCategoryProvider implements \Zento\Contracts\Catalog\CategoryProvider {
     /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCategoryById($identifier)
    {
        return Category::where($model->getCategoryIdentifierName(), $identifier)
            ->first();
    }

    public function getCategoriesByLevel($level, $withs = [], $parent_id = -1) {
        return Category::where('level', $level)
            ->orderBy('sort_by')
            ->get();
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
}