<?php

if (!function_exists('zento_assert')) {
    function zento_assert($obj, $interface = false) {
        if (app()->environment(['local', 'staging'])) {
            if (!$obj) {
                $errorMessage = sprintf('Assert object is null');
                trigger_error($errorMessage, E_USER_ERROR);
            }

            $PROPERTIES = false;
            if ($obj instanceof \Zento\Contracts\AssertAbleInterface) {
                $PROPERTIES = $obj::PROPERTIES;
            } elseif (!empty($interface)) {
                $PROPERTIES = $interface::PROPERTIES;
            }

            if (!$PROPERTIES) {

                $errorMessage = sprintf('Assert object is not an instance of \Zento\Contracts\AssertAbleInterface, then you need to define the assert interface');
                trigger_error($errorMessage, E_USER_ERROR);
            }
        
            $diffs = [];
            if ($obj instanceof \Illuminate\Database\Eloquent\Model 
                || $obj instanceof \Zento\Contracts\ReadOnlyObject) 
            {
                $attributes = $obj->getAttributes();
                if (!empty($attributes)) {
                    $diffs = array_diff($PROPERTIES, array_keys($attributes));
                }
                if (count($diffs) > 0 && method_exists($obj, 'getRelations')) {
                    $diffs = array_diff($diffs, array_keys($obj->getRelations()));
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
                $diffs = $PROPERTIES;
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

if (!function_exists('generateReadOnlyModelFromArray')) {
    function generateReadOnlyModelFromArray($className, array $attrs = []) {
        $instance = null;
        eval('$instance = new class extends ' . $className . ' {
            public function _fill_(array $attrs = []) {
                foreach($attrs as $key => $value) {
                    if (is_string($key) && is_array($value)) {
                        if ($relation = $this->{$key}()) {
                            $model = $relation->getQuery()->getModel();
                            if ($relation instanceof \Illuminate\Database\Eloquent\Relations\HasOne) {
                                $obj = generateReadOnlyModelFromArray(get_class($model), $value);
                                $this->setRelation($key, $obj);
                            } else {
                                $items = [];
                                foreach($value as $item) {
                                    $items[] = generateReadOnlyModelFromArray(get_class($model), $item);
                                }
                                $this->setRelation($key, $items);
                            }
                        } else {
                            $this->setAttribute($key, $value);
                        }
                    } else {
                        $this->setAttribute($key, $value);
                    }
                }
            } 
            use \Zento\Kernel\Booster\Database\Eloquent\ReadOnly\TraitReadOnly;
        };');
        $instance->_fill_($attrs);
        return $instance;
    }
}

if (!function_exists('array2ReadOnlyObject')) {
    function array2ReadOnlyObject(array $attrs, $interface = '') {
        $instance = null;
        if (!empty($interface)) {
            $interface = ' implements ' . $interface;
        }
        eval('$instance = new class($attrs) extends \Zento\Contracts\ReadOnlyObject' . $interface . '{};');
        return $instance;
    }
}