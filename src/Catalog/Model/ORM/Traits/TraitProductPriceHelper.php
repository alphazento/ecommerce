<?php

namespace Zento\Catalog\Model\ORM\Traits;

use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductSpecialPrice;

trait TraitProductPriceHelper {
    public function priceDataset() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function specialPriceDataset() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    protected function getPriceDatasetRelation() {
        if (!$this->priceDataset) {
            $instance = new ProductPrice();
            $instance->product_id = $this->id;
            $this->relations['priceDataset'] = $instance;
        }
        return $this->priceDataset;
    }

    protected function getSpecialPriceDatasetRelation() {
        if (!$this->specialPriceDataset) {
            $instance = new ProductSpecialPrice();
            $instance->product_id = $this->id;
            $this->relations['specialPriceDataset'] = $instance;
        }
        return $this->specialPriceDataset;
    }

    public function getRrpAttribute() {
        return $this->priceDataset ? $this->priceDataset->rrp : null;
    }

    public function getCostAttribute() {
        return $this->priceDataset ? $this->priceDataset->cost : null;
    }

    public function getPriceAttribute() {
        return $this->priceDataset ? $this->priceDataset->price : null;
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
        return $this->specialPriceDataset ? $this->specialPriceDataset->price : null;
    }

    public function setSpecialPriceAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->price = $value;
        return $this;
    }

    public function getSpecialFromAttribute() {
        return $this->specialPriceDataset ? $this->specialPriceDataset->from_date : null;
    }

    public function setSpecialFromAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->from_date = $value;
        return $this;
    }

    public function getSpecialToAttribute() {
        return $this->specialPriceDataset ? $this->specialPriceDataset->to_date : null;
    }

    public function setSpecialToAttribute($value) {
        $this->getSpecialPriceDatasetRelation()->to_date = $value;
        return $this;
    }
}