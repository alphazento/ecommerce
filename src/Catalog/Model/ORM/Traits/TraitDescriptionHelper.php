<?php

namespace Zento\Catalog\Model\ORM\Traits;

/**
 * a trait to handle category or product description
 * Descripiton is a relation to category class or product class
 * This trait turn relationship's properties to some mutators
 * The class which use this trait need to define static properties: $DesciptionModel and $DesciptionModelForeignKey
 */
trait TraitDescriptionHelper {
    public function descriptionDataset() {
        return $this->hasOne(static::$DesciptionModel, static::$DesciptionModelForeignKey);
    }

    protected function getDescriptionDatasetRelation() {
        if (!$this->descriptionDataset) {
            $class = static::$DesciptionModel;
            $instance = new $class();
            $instance->{static::$DesciptionModelForeignKey} = $this->id;
            $this->relations['descriptionDataset'] = $instance;
        }
        return $this->descriptionDataset;
    }

    public function getDescriptionAttribute() {
        return $this->descriptionDataset ? $this->descriptionDataset->description : null;
    }

    public function getNameAttribute() {
        return $this->descriptionDataset ? $this->descriptionDataset->name : null;
    }

    public function getMetaTitleAttribute() {
        return $this->descriptionDataset ? $this->descriptionDataset->meta_title : null;
    }

    public function getMetaDescriptionAttribute() {
        return $this->descriptionDataset ? $this->descriptionDataset->meta_description : null;
    }

    public function getMetaKeywordAttribute() {
        return $this->descriptionDataset ? $this->descriptionDataset->meta_keyword : null;
    }

    public function setDescriptionAttribute($value) {
        $this->getDescriptionDatasetRelation()->description = $value;
        return $this;
    }

    public function setNameAttribute($value) {
        $this->getDescriptionDatasetRelation()->name = $value;
        return $this;
    }

    public function setMetaTitleAttribute($value) {
        $this->getDescriptionDatasetRelation()->meta_title = $value;
        return $this;
    }

    public function setMetaDescriptionAttribute($value) {
        $this->getDescriptionDatasetRelation()->meta_description = $value;
        return $this;
    }

    public function setMetaKeywordAttribute($value) {
        $this->getDescriptionDatasetRelation()->meta_keyword = $value;
        return $this;
    }
}