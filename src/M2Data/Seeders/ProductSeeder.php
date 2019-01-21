<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Facades\DanamicAttributeFactory;
use Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\ORM\AttributeInSet;

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
                'decimalattrs.codedesc',
                'galleryattrs.codedesc',
                'galleryattrs.galleryvalue',
                'galleryattrs.video',
            ])
            ->get();
        foreach($collection as $item) {
            $product = Product::find($item->entity_id);
            if ($product) {
                $product->exists = true;
            } else {
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

            foreach(['integer', 'text', 'varchar', 'datetime', 'decimal', 'gallery'] as $ftype) {
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

                    $isSingleDyn = $this->isSingleEav($eavItem->codedesc->frontend_input);
                    $attrId = DanamicAttributeFactory::createRelationShipORM($product,
                        $eavItem->codedesc->attribute_code, 
                        [$ftype === 'gallery' ? 'varchar' : $ftype], 
                        $isSingleDyn,
                        !empty($eavItem->codedesc->options)
                    );
                    
                    $attrInSet = AttributeInSet::where('attribute_set_id', $product->attribute_set_id)
                        ->where('attribute_id', $attrId)
                        ->first();
                    if (!$attrInSet) {
                        $attrInSet = new AttributeInSet();
                    }
                    $attrInSet->attribute_set_id = $product->attribute_set_id;
                    $attrInSet->attribute_id = $attrId;
                    $attrInSet->save();

                    //migrate option value
                    $this->migrateOptionValue($eavItem->codedesc, 'products', $attrId);
                    
                    if ($eavItem->value) {
                        if ($isSingleDyn) {
                            DanamicAttributeFactory::single($product, $eavItem->codedesc->attribute_code)->newValue($eavItem->value);
                        } else {
                            if ($options = DanamicAttributeFactory::option($product, $eavItem->codedesc->attribute_code)) {
                                if ($eavItem->codedesc->frontend_input == 'multiselect') {
                                    $values = explode(',', $eavItem->value);
                                } else {
                                    $values = [$eavItem->value];
                                }
                                foreach($values as $value) {
                                    $options->newValue($value);
                                }
                            }
                        }
                    }
                }
            }
            $product->unsetRelation('configurables');
            $product->push();
        }
    }
}