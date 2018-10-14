<?php

namespace Zento\Catalog\Model\ORM\Traits;

use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductSpecialPrice;

/**
 * a trait to handle product price
 * This trait turn relationship's properties to some mutators
 */
trait TraitProductPriceHelper {
    public function price_dataset() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function special_price_dataset() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    protected function getPriceDatasetRelation() {
        if (!$this->price_dataset) {
            $instance = new ProductPrice();
            $instance->product_id = $this->id;
            $this->relations['price_dataset'] = $instance;
        }
        return $this->price_dataset;
    }

    protected function getSpecialPriceDatasetRelation() {
        if (!$this->special_price_dataset) {
            $instance = new ProductSpecialPrice();
            $instance->product_id = $this->id;
            $this->relations['special_price_dataset'] = $instance;
        }
        return $this->special_price_dataset;
    }

    public function getRrpAttribute() {
        return $this->price_dataset ? $this->price_dataset->rrp : null;
    }

    public function getCostAttribute() {
        return $this->price_dataset ? $this->price_dataset->cost : null;
    }

    public function getPriceAttribute() {
        return $this->price_dataset ? $this->price_dataset->price : null;
    }

    public function setRrpAttribute($value) {
        $this->getPriceDatasetRelation()->name = $value;
        return $this;
    }

    public function setCostAttribute($value) {
        $this->getPriceDatasetRelation()->cost = $value;
        return $this;
    }

    public function setPriceAttribute($value) {
        $this->getPriceDatasetRelation()->price = $value;
        return $this;
    }


    public function getSpecialPriceAttribute() {
        return $this->special_price_dataset ? $this->special_price_dataset->price : null;
    }

    public function setSpecialPriceAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->price = $value;
        return $this;
    }

    public function getSpecialFromAttribute() {
        return $this->special_price_dataset ? $this->special_price_dataset->from_date : null;
    }

    public function setSpecialFromAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->from_date = $value;
        return $this;
    }

    public function getSpecialToAttribute() {
        return $this->special_price_dataset ? $this->special_price_dataset->to_date : null;
    }

    public function setSpecialToAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->to_date = $value;
        return $this;
    }
}