<?php

namespace Zento\Contracts\Service;
use Zento\Contracts\Interfaces\Catalog\ICategory;

interface CategoryServiceInterface
{
    /**
     * Retrieve a category by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Zento\Contracts\Interfaces\Catalog\ICategory|null
     */
    public function getCategoryById($id);
    
    public function getCategoriesByLevel($level, $activeOnly = true,  $parent_id = -1);

    /**
     * Retrieve root category of the store
     *
     * @return \Zento\Contracts\Interfaces\Catalog\ICategory|null
     */
    public function root();

    /**
     * Retrieve category tree from root
     *
     * @return void
     */
    public function tree();
    
    public function getName(ICategory $category, $withProductCount = false);
}
