<?php

namespace Zento\Catalog\Model\ORM\Traits;

trait TraitDescriptionHelper {
    public function descriptionDataset() {
        return $this->hasOne($this->desciptionModel, $this->desciptionModelForeignKey);
    }

    protected function getDescriptionDatasetRelation() {
        if (!$this->descriptionDataset) {
            $class = $this->desciptionModel;
            $instance = new $class();
            $instance->{$this->desciptionModelForeignKey} = $this->id;
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