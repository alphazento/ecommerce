<?php

namespace Zento\Customer\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class CustomerAddress extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Interfaces\IAddress
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    protected $fillable = [
        'customer_id',
        'name',
        "company",
        "address1",
        "address2",
        "city",
        "country",
        "postal_code",
        "state",
        "phone",
        "address_type"
    ];

    public function uniqueHash() {
        $strArray = [];
        $values = $this->toArray();
        foreach($this->fillable as $key) {
            $strArray[] = isset($values[$key]) ? $values[$key] : '';
            unset($values[$key]);
        }
        $strArray = array_merge($strArray, $values);
        return md5(implode('||', array_values($strArray)));
    }

    public function save(array $options = []) {
        $this->hash = $this->uniqueHash();
        return parent::save($options);
    }
}