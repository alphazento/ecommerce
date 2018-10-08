<?php

namespace Zento\Catalog\Model\ORM\Traits;

/**
 * a trait to handle product price
 * This trait turn relationship's properties to direct attributes of the host class by override function "toArray"
 * to use this trait, host class must define a static property: $relationToMutators
 */
trait TraitRealationMutatorHelper {
    public function toArray() {
        $origin = parent::toArray();
        foreach(static::$RelationToMutators as $relation => $items) {
            foreach($items as $mutator) {
                $origin[$mutator] = $this->{$mutator};
            }
            unset($origin[$relation]);
        }
        return $origin;
    }
}