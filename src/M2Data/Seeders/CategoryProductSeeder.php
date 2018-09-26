<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\CategoryProduct;

class CategoryProductSeeder extends \Illuminate\Database\Seeder {
    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\Catalog\CategoryProduct::get();
        foreach($collection as $item) {
            $category = CategoryProduct::updateOrCreate(
                [
                    'category_id' => $item->category_id,
                    'product_id' => $item->product_id,
                ],
                [
                    'category_id' => $item->category_id,
                    'product_id' => $item->product_id,
                    'position' => $item->product_id,
                ]);

            $category->save();
        }
    }
}