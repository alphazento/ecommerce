<?php

namespace Zento\Catalog\Model\ORM\Traits;

use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductSpecialPrice;

trait TraitProductPriceHelper {
    public function pricecontainer() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function specialpricecontainer() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    protected function getPriceContainerRelation() {
        if (!$this->pricecontainer) {
            $instance = new ProductPrice();
            $instance->product_id = $this->id;
            $this->relations['pricecontainer'] = $instance;
        }
        return $this->pricecontainer;
    }

    protected function getSpecialPriceContainerRelation() {
        if (!$this->specialpricecontainer) {
            $instance = new ProductSpecialPrice();
            $instance->product_id = $this->id;
            $this->relations['specialpricecontainer'] = $instance;
        }
        return $this->specialpricecontainer;
    }

    public function getRrpAttribute() {
        return $this->pricecontainer ? $this->pricecontainer->rrp : null;
    }

    public function getCostAttribute() {
        return $this->pricecontainer ? $this->pricecontainer->cost : null;
    }

    public function getPriceAttribute() {
        return $this->pricecontainer ? $this->pricecontainer->price : null;
    }

    public function setRrpAttribute($value) {
        $this->getPriceContainerRelation()->name = $value;
        return $this;
    }

    public function setCostAttribute($value) {
        $this->getPriceContainerRelation()->cost = $value;
        return $this;
    }

    public function setPriceAttribute($value) {
        $this->getPriceContainerRelation()->price = $value;
        return $this;
    }


    public function getSpecialPriceAttribute() {
        return $this->specialpricecontainer ? $this->specialpricecontainer->price : null;
    }

    public function setSpecialPriceAttribute($value) {
        $this->getSpecialPriceContainerRelation()->price = $value;
        return $this;
    }

    public function getSpecialFromAttribute() {
        return $this->specialpricecontainer ? $this->specialpricecontainer->from_date : null;
    }

    public function setSpecialFromAttribute($value) {
        $this->getSpecialPriceContainerRelation()->from_date = $value;
        return $this;
    }

    public function getSpecialToAttribute() {
        return $this->specialpricecontainer ? $this->specialpricecontainer->to_date : null;
    }

    public function setSpecialToAttribute($value) {
        $this->getSpecialPriceContainerRelation()->to_date = $value;
        return $this;
    }
}