<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\M2Data\Model\ORM\Catalog\CategoryProductSuperLink;
use Zento\ConfigurableProduct\Model\ORM\ConfigurableProduct;

class CategoryProductSuperLinkSeeder extends \Illuminate\Database\Seeder {
    public function run()
    {
        $collection = CategoryProductSuperLink::get();
        foreach($collection as $item) {
            $link = ConfigurableProduct::updateOrCreate(
                [
                    'product_id' => $item->product_id,
                    'parent_id' => $item->parent_id,
                ],
                [
                    'product_id' => $item->product_id,
                    'parent_id' => $item->parent_id,
                ]);
            $link->save();
        }
    }
}