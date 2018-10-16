<?php

namespace Zento\ShoppingCart\Model\ORM\Traits;

trait ParallelShoppingCartItem
{
    public function getId() {
        return $this->id;
    }

    public function getCartId() {
        return $this->cart_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getImage() {
        return $this->image;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getMinQuantity() {
        return $this->min_quantity;
    }

    public function getMaxQuantity() {
        return $this->max_quantity;
    }

    public function getStackable() {
        return $this->stackable;
    }

    public function getShippable() {
        return $this->shippable;
    }

    public function getTaxable() {
        return $this->taxable;
    }

    public function getDuplicatable() {
        return $this->duplicatable;
    }

    public function getUnitPrice() {
        return $this->unit_price;
    }
    
    public function getTotalPrice() {
        return $this->total_price;
    }

    // public function getRecurring();
    public function getCustomFields() {
        return [];
    }

    public function getOptions() {
        return $this->options;
    }

}
