<?php

if (!function_exists('zento_assert')) {
    function zento_assert(\Zento\Contracts\AssertAbleInterface $obj) {
        if (app()->environment(['local', 'staging'])) {
            $diffs = [];
            if ($obj instanceof \Illuminate\Database\Eloquent\Model) {
                $attributes = $obj->getAttributes();
                if (!empty($attributes)) {
                    $attributes = array_merge(array_keys($attributes), array_keys($obj->getRelations()));
                    $diffs = array_diff($obj::PROPERTIES, $attributes);
                }
                if (count($diffs) > 0 && method_exists($obj, 'getPreloadRelations')) {
                    $extraProperties = array_values(array_filter($obj->getPreloadRelations(), function($v, $k) {
                        return is_array($v);
                    }, ARRAY_FILTER_USE_BOTH));
                    foreach($extraProperties as $sets) {
                        $diffs = array_diff($diffs, $sets);
                        if (count($diffs) == 0) {
                            break;
                        }
                    }
                }
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