<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\ORM\AttributeSet;

use Zento\Kernel\Facades\DanamicAttributeFactory;

class AttributeSetSeeder extends \Illuminate\Database\Seeder {

    protected $models_map = ['1' => 'customers', '2' => 'customer_addresses', 
        '3' => 'categories', '4'=>'products', 
        '5' => 'null', '6'=> 'null',
        '7' => 'null', '8'=> 'null'
        // '9'=>'categories', '10'=>'products',
        // '18'=>'invoices', '19' =>'default', '21' => 'default',
        // '24'=>'shipments', '28'=>'creditmemos',
    ];
    
    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\EavAttributeSet::get();
        foreach($collection as $item) {
            $attrSet = AttributeSet::find($item->attribute_set_id);
            if (!$attrSet) {
                $attrSet = new AttributeSet();
            }
            $attrSet->id = $item->attribute_set_id;
            $attrSet->model = $this->models_map[$item->entity_type_id];
            $attrSet->name = $item->attribute_set_name;
            $attrSet->save();
        }
    }
}