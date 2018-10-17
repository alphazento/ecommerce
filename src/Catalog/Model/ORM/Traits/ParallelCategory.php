<?php

namespace Zento\Catalog\Model\ORM\Traits;

use Zento\Catalog\Model\ORM\ProductPrice;
use Zento\Catalog\Model\ORM\ProductSpecialPrice;

/**
 * a trait to handle product price
 * This trait turn relationship's properties to some mutators
 */
trait ParallelCategory {
    public function getId() {
        return $this->id;
    }
}