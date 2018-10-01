<?php

namespace Zento\Catalog\Model\ORM\Traits;

trait TraitDescriptionHelper {
    // protected $RelationModels = [
    //     'description' => [
    //         'class' => ProductDescription::class,
    //         'foreignKey' =>'product_id'
    //     ]
    // ];
    public function desccontainer() {
        return $this->hasOne(static::$RelationModels['description']['class'], static::$RelationModels['description']['foreignKey']);
    }

    protected function getDescContainerRelation() {
        if (!$this->desccontainer) {
            $class = static::$RelationModels['description']['class'];
            $instance = new $class();
            $instance->{static::$RelationModels['description']['foreignKey']} = $this->id;
            $this->relations['desccontainer'] = $instance;
        }
        return $this->desccontainer;
    }

    public function getDescriptionAttribute() {
        return $this->desccontainer ? $this->desccontainer->description : null;
    }

    public function getNameAttribute() {
        return $this->desccontainer ? $this->desccontainer->name : null;
    }

    public function getMetaTitleAttribute() {
        return $this->desccontainer ? $this->desccontainer->meta_title : null;
    }

    public function getMetaDescriptionAttribute() {
        return $this->desccontainer ? $this->desccontainer->meta_description : null;
    }

    public function getMetaKeywordAttribute() {
        return $this->desccontainer ? $this->desccontainer->meta_keyword : null;
    }

    public function setDescriptionAttribute($value) {
        $this->getDescContainerRelation()->description = $value;
        return $this;
    }

    public function setNameAttribute($value) {
        $this->getDescContainerRelation()->name = $value;
        return $this;
    }

    public function setMetaTitleAttribute($value) {
        $this->getDescContainerRelation()->meta_title = $value;
        return $this;
    }

    public function setMetaDescriptionAttribute($value) {
        $this->getDescContainerRelation()->meta_description = $value;
        return $this;
    }

    public function setMetaKeywordAttribute($value) {
        $this->getDescContainerRelation()->meta_keyword = $value;
        return $this;
    }
}