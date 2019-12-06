<?php

namespace Zento\DownloadableProduct\Model\ORM;

use Zento\Catalog\Model\ORM\Product as SimpleProduct;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Illuminate\Support\Collection;

class Product extends SimpleProduct
{
    const TYPE_ID = "downloadable";

    public function shippable() {
        return false;
    }

    public function downloadConfig() {
        return $this->hasOne(DownloadableProductConfig::class, 'product_id', 'id');
    }

    public function canDownload($user) {
        return false;
        // if ($this->free) {
        //     return true;
        // }
        // if ($this->customerFree) {
        //     return true;
        // }

        // if ($this->purchasedByUser($user)) {
        //     return true;
        // }
    }

    public static function assignExtraRelation($products) {
        list($reduced, $ids) = parent::assignExtraRelation($products);

        if (count($ids) > 0) {
            // foreach($collection as $)
            $name = 'downloadConfig';
            $relation = (new static)->downloadConfig();
            $relation->orWhereIn('product_id', $ids);
            $relation->match(
                $relation->initRelation($reduced, $name),
                $relation->getEager(), 
                $name
            );
        }
    }

    public function findExistCartItem(IShoppingCart $cart, array &$options) {
        if ($item = parent::findExistCartItem($cart, $options)) {
            //if the download be quantitative so every time add product quantity will change
            //otherwise quantity will always be 1
            if (!($this->downloadConfig->quantitative ?? false)) {
                $item->quantity = 0;
            }
            return $item;
        }
        return false;
    }
}