<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Product
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    private static $typeMap = [
        'simple' => '\Zento\Catalog\Model\ORM\Product'
    ];

    public static function registerType($type_id, $class) {
        self::$typeMap[$type_id] = $class;
    }
   
    public function product_description() {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }

    public function product_price() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function product_special_price() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    public static function getPreloadRelations() {
        return [
            'product_description' => [
                'description', 'name', 'meta_title', 'meta_description', 'meta_keyword'
            ],
            'product_price' => [
                'rrp', 'cost', 'price',
            ],
            'product_special_price' => [
                'special_price', 'special_from', 'special_to'
            ]
        ];
    }

    /**
     * @override from \Illuminate\Database\Eloquent\Model
     *
     * @param  array  $attributes
     * @param  string|null  $connection
     * @return static
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = $this->newInstanceBaseTypeId($attributes);

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    protected function newInstanceBaseTypeId($attributes = []) {
        $type_id = false;
        if (is_array($attributes)) {
            if (isset($attributes['type_id'])) {
                $type_id = $attributes['type_id'];
            }
        } elseif (is_object($attributes)) {
            $type_id = $attributes->type_id;
        }
        
        if ($type_id) {
            if (isset(self::$typeMap[$type_id])) {
                $class = self::$typeMap[$type_id];
                return new $class([], true);
            }
        } else {
            return $this->newInstance([], true);
        }
    } 
}