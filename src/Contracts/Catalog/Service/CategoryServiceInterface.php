<?php

namespace Zento\Contracts\Catalog\Service;

interface CategoryServiceInterface
{
    /**
     * Retrieve a category by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Zento\Contracts\Catalog\Model\Category|null
     */
    public function getCategoryById($id);
    
    public function getCategoriesByLevel($level, $activeOnly = true,  $parent_id = -1);

    /**
     * Retrieve root category of the store
     *
     * @return \Zento\Contracts\Catalog\Model\Category|null
     */
    public function root();

    /**
     * Retrieve category tree from root
     *
     * @return void
     */
    public function tree();
    
    public function getName(\Zento\Contracts\Catalog\Model\Category $category, $withProductCount = false);
}
