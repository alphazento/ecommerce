<?php

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Category;
use Zento\Catalog\Model\ORM\Product;
use Zento\Catalog\Model\ORM\CategoryProduct;

class Seeder extends \Illuminate\Database\Seeder {
    public function run()
    {
        $collection = DB::table('catalog_category_entity')->get();
        foreach($collection as $item) {
            $category = new Category();
            $category->id = $item->entity_id;
            $category->dynacolumn_set_id = $item->attribute_set_id;
            $category->parent_id = $item->parent_id;
            $category->path = $item->path;
            $category->hash = md5($item->path);
            $category->position = $item->position;
            $category->level = $item->level;
            $category->children_count = $item->children_count;
            $category->active = true;
            $category->name = 'category' . $category->id;
            $category->image = '';
            $category->description = '';
            $category->save();
        }
        
        $collection = DB::table('catalog_product_entity')->get();
        foreach($collection as $item) {
            $product = new Product();
            $product->id = $item->entity_id;
            $product->dynacolumn_set_id = $item->attribute_set_id;
            $product->type_id = $item->type_id;
            $product->has_options = $item->has_options;
            $product->required_options = md5($item->required_options);
            $product->sku = $item->sku;
            $product->active = true;
            $product->name = 'category' . $category->id;
            $product->description = '';
            $product->save();
        }

        $collection = DB::table('catalog_product_entity')->get();
        foreach($collection as $item) {
            $product = new Product();
            $product->id = $item->entity_id;
            $product->dynacolumn_set_id = $item->attribute_set_id;
            $product->type_id = $item->type_id;
            $product->has_options = $item->has_options;
            $product->required_options = md5($item->required_options);
            $product->sku = $item->sku;
            $product->active = true;
            $product->name = 'category' . $category->id;
            $product->description = '';
            $product->save();
        }
    }
}