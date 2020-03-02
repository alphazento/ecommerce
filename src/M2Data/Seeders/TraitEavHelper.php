<?php
namespace Zento\M2Data\Seeders;

use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeValueMap;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

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

    protected function migrateOptionValue(\Zento\M2Data\Model\ORM\EavAttribute $codedesc, $modelName, $attrId = 0) {
        if (!$codedesc->options) return;

        $dynAttribute = null;
        if (!$attrId) {
            if ($dynAttribute = DynamicAttribute::where('parent_table', $model)
                    ->where('name', $codedesc->attribute_code)
                    ->first()) 
            {
                $attrId = $dynAttribute->id;
            }
        } else {
            $dynAttribute = DynamicAttribute::find($attrId);
        }
        if ($attrId) {
            foreach($codedesc->options as $option) {
                $attrValue = DynamicAttributeValueMap::where('attribute_id', $attrId)
                    ->where('value_id', $option->option_id)
                    ->first();
                if (!$attrValue && $option->value) {
                    if ($option->swatch) {
                        $dynAttribute->swatch_type = 1 + $option->swatch->type;
                        $dynAttribute->update();
                    }
                    $attrValue = DynamicAttributeValueMap::create([
                        'attribute_id' => $attrId, 
                        'value_id'=>$option->option_id,
                        'value' => $option->value->value,
                        'swatch_value' => ($option->swatch ? $option->swatch->value : null)
                        ]);
                }
            }
            
        }
    }
}
    