<?php

namespace Zento\ElsCatalog\Processor;

use Zento\Catalog\Services\CategoryService;
use Zento\ElsCatalog\Model\ElsIndex\Category;

class CategorySync {
    public function sync() {
        $service = new CategoryService();
        $collection = $service->tree(false);
        foreach($collection as $item) {
            $this->sync_item($item);
        }
    }

    protected function sync_item($ormCategory) {
        $category = null;
        try {
            $category = Category::where('id', '=', $ormCategory->id)->first();
        } catch (\Exception $e) {

        }
        if (!$category) {
            $category = new Category();
        }
        $category->forceFill($ormCategory->toArray());
        $category->save();
        foreach($ormCategory->children as $subCategory) {
            $this->sync_item($subCategory);
        }
    }
}