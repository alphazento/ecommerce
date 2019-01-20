<?php
namespace Zento\M2Data\Seeders;

use Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\ORM\AttributeValueMap;
use Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\ORM\ModelDynamicAttribute;

trait TraitEavHelper {
    protected function isSingleEav($frontend_input) {
        switch($frontend_input) {
            case 'text':
            case 'hidden':
            case 'select':
            case 'multiline':
            case 'textarea':
            case 'price':
            case 'weight':
            case 'media_image':
            case 'date':
            case 'boolean':
                return true;
            case 'multiselect':
            case 'gallery':
                return false;
        }
        return true;
    }

    protected function migrateOptionValue($codedesc, $modelName, $attrId = 0) {
        if (!$codedesc->options) return;

        if (!$attrId) {
            if ($dynAttribute = ModelDynamicAttribute::where('model', $model)->where('attribute', $codedesc->attribute_code)->first()) {
                $attrId = $dynAttribute->id;
            }
        }
        if ($attrId) {
            foreach($codedesc->options as $option) {
                $attrValue = AttributeValueMap::where('attribute_id', $attrId)
                    ->where('value_id', $option->option_id)
                    ->first();
                if (!$attrValue && $option->value) {
                    $attrValue = AttributeValueMap::create([
                        'attribute_id' => $attrId, 
                        'value_id'=>$option->option_id,
                        'value' => $option->value->value
                        ]);
                }
            }
            
        }
    }
}
    