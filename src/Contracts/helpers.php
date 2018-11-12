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

if (!function_exists('guidv4')) {
    function guidv4() {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        } else {
            throw new \Exception('function openssl_random_pseudo_bytes not exist.');
        }
    }
}