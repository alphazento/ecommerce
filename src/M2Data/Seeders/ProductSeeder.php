<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\DynaColumnFactory;

class ProductSeeder extends \Illuminate\Database\Seeder {
    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\Product::with(['integerattrs.codedesc',
            'varcharattrs.codedesc', 
            'textattrs.codedesc',
            'datetimeattrs.codedesc',
            'decimalattrs.codedesc'])
            ->get();
        foreach($collection as $item) {
            $product = new Product();
            $product->id = $item->entity_id;
            $product->dynacolumn_set_id = $item->attribute_set_id;
            $product->type_id = $item->type_id;
            $product->has_options = $item->has_options;
            $product->required_options = $item->required_options;
            $product->sku = $item->sku;
            $product->active = true;
            $product->name = 'product' . $product->id;
            $product->description = '';
            // $product->save();

            foreach($item->integerattrs as $intItem) {
                if (!$intItem->codedesc) {
                    continue;
                }
                $isSingle = $intItem->codedesc->front_input !== 'select';
                DynaColumnFactory::createRelationShipORM($product,
                    $intItem->codedesc->attribute_code, ['integer'], 
                    $isSingle);
                
                if ($intItem->value) {
                    echo sprintf('product %s code:%s value:%s' . PHP_EOL, $item->entity_id, $intItem->codedesc->attribute_code, $intItem->value);
                    DynaColumnFactory::single($product, $intItem->codedesc->attribute_code)->new($intItem->value);
                }
            }
        }
    }
}