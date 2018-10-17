<?php

if (!function_exists('zento_assert')) {
    function zento_assert(\Zento\Contracts\AssertAbleInterface $obj) {
        if (app()->environment(['local', 'staging'])) {
            $exists = [];
            $diffs = [];
            if ($obj instanceof \Illuminate\Database\Eloquent\Model) {
                $attributes = array_merge(array_keys($obj->getAttributes()), array_keys($obj->getRelations()));
                $diffs = array_diff($obj::PROPERTIES, $attributes);
            } else {
                $diffs = $obj::PROPERTIES;
            }
            $not_exists = [];
            foreach($diffs as $property) {
                if (!property_exists($obj, $property)) {
                    $not_exists[] = $property;
                }
            }
            if (count($not_exists)) {
                $errorMessage = sprintf('Properties [%s] are not defined in class %s', implode(',', $not_exists), get_class($obj));
                trigger_error($errorMessage, E_USER_ERROR);
            }
        }
    }
}