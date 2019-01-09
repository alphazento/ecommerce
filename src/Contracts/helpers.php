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
    function array2ReadOnlyObject($interface, array $attrs) {
        $instance = null;
        eval('$instance = new class($attrs) implements ' . $interface . ' {
            protected $attrs;

            public function __construct(array $attrs) {
                $this->attrs = $attrs;
            }

            public function getData() {
                return $this->attrs;
            }

            public function __get($key) {
                return isset($this->attrs[$key]) ? $this->attrs[$key] : null;
            }

            public function __set($key, $value) {
                throw new \Exception("This model is read only");
            }
        };');
        return $instance;
    }
}