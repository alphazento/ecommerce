<?php

namespace Zento\Catalog\Model\ORM\Concerns;

use Auth;
use Zento\Catalog\Model\ORM\Product\ProductPrice;
use Zento\Catalog\Model\ORM\Product\ProductSpecialPrice;

trait TraitProductPrice
{
    /**
     * if frontend it will only get this price
     */
    public function price()
    {
        $groupId = Auth::user()->group_id ?? 0;
        return $this->hasOne(ProductPrice::class, 'product_id')
            ->whereIn('customer_group_id', [$groupId, 0])
            ->orderBy('customer_group_id', 'desc');
    }

    /**
     * admin portal support customer groups
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function specialPrices()
    {
        return $this->hasMany(ProductSpecialPrice::class, 'product_id');
    }

    public function getFinalPriceAttribute()
    {
        return $this->price->final_price ?? 0;
    }
}
