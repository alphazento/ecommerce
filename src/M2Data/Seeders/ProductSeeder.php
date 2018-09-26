<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\DynaColumnFactory;

class ProductSeeder extends \Illuminate\Database\Seeder {
    use TraitEavHelper;

    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\Catalog\Product::with(
            [
                'integerattrs.codedesc',
                'varcharattrs.codedesc', 
                'textattrs.codedesc',
                'datetimeattrs.codedesc',
                'decimalattrs.codedesc'
            ])
            ->get();
        foreach($collection as $item) {
            $product = Product::find($item->entity_id);
            if (!$product) {
                $product = new Product();
            }
            $product->id = $item->entity_id;
            $product->dynacolumn_set_id = $item->attribute_set_id;
            $product->type_id = $item->type_id;
            $product->has_options = $item->has_options;
            $product->required_options = $item->required_options;
            $product->sku = $item->sku;
            $product->active = true;
            $product->name = 'product' . $product->id;
            $product->save();

            foreach(['integer','text', 'varchar', 'datetime', 'decimal'] as $ftype) {
                $relation = $ftype .'attrs';
                foreach($item->{$relation} ?? [] as $eavItem) {
                    if (!$eavItem->codedesc) {
                        continue;
                    }
                    if ($eavItem->codedesc->attribute_code == 'name') {
                        $product->name = $eavItem->value;
                        $product->update();
                    }
                    DynaColumnFactory::createRelationShipORM($product,
                        $eavItem->codedesc->attribute_code, [$ftype], 
                        $this->isSingleEav($eavItem->codedesc->frontend_input));
                    
                    if ($eavItem->value) {
                        DynaColumnFactory::single($product, $eavItem->codedesc->attribute_code)->new($eavItem->value);
                    }
                }
            }
        }
    }


    protected function getRealType($item) {
        if ($item->codedesc->options && count(($item->codedesc->options))) {
            // print_r($item->codedesc->options);
            echo sprintf('product %s code:%s value:%s input[%s] option' . PHP_EOL, 
                $item->entity_id, $item->codedesc->attribute_code, $item->value, $item->codedesc->frontend_input);
        } else {
            echo sprintf('product %s code:%s value:%s input[%s] single' . PHP_EOL, 
            $item->entity_id, $item->codedesc->attribute_code, $item->value, $item->codedesc->frontend_input);
        }
    }
}