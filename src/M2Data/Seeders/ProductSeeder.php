<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\DanamicAttributeFactory;

class ProductSeeder extends \Illuminate\Database\Seeder {
    use TraitEavHelper;

    protected $attrsInMainTable = [
        'default_sort_by' => 'sort_by',         //m2 attr => zento
        'is_active' => 'is_active',

        //description group
        'name' => 'name',         //m2 attr => zento
        'description' => 'description',
        'meta_description' => 'meta_description',         //m2 attr => zento
        'meta_keyword' => 'meta_keyword',
        'meta_title' => 'meta_title',

        //price group
        'cost' => 'cost',
        'price' => 'price',
        'rrp' => 'rrp',
        'special_price' => 'special_price',
        'special_from_date' => 'special_from',
        'special_to_date' => 'special_to',
    ];

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
            $product->attribute_set_id = $item->attribute_set_id;
            $product->type_id = $item->type_id;
            $product->has_options = $item->has_options;
            $product->required_options = $item->required_options;
            $product->sku = $item->sku;
            $product->active = true;
            $product->save();

            foreach(['integer','text', 'varchar', 'datetime', 'decimal'] as $ftype) {
                $relation = $ftype .'attrs';
                foreach($item->{$relation} ?? [] as $eavItem) {
                    if (!$eavItem->codedesc) {
                        continue;
                    }
               
                    $attrKeysInMainTable = array_keys($this->attrsInMainTable);
                    if (in_array($eavItem->codedesc->attribute_code, $attrKeysInMainTable)) {
                        $zentoKey = $this->attrsInMainTable[$eavItem->codedesc->attribute_code];
                        $product->{$zentoKey} = $eavItem->value;
                        continue;
                    }
                    DanamicAttributeFactory::createRelationShipORM($product,
                        $eavItem->codedesc->attribute_code, [$ftype], 
                        $this->isSingleEav($eavItem->codedesc->frontend_input));
                    
                    if ($eavItem->value) {
                        DanamicAttributeFactory::single($product, $eavItem->codedesc->attribute_code)->new($eavItem->value);
                    }
                }
            }
            $product->push();
        }
    }
}