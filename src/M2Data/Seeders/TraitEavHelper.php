<?php
namespace Zento\M2Data\Seeders;


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
}
    