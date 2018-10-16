<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCartItem
{
    public function getId();

    public function getCartId();

    public function getName();

    public function getSku();

    public function getPrice();

    public function getDescription();

    public function getUrl();

    public function getImage();

    public function getQuantity();

    public function getMinQuantity();

    public function getMaxQuantity();

    public function getStackable();

    public function getShippable();

    public function getTaxable();

    public function getDuplicatable();

    public function getUnitPrice();
    
    public function getTotalPrice();

    // public function getRecurring();
    public function getCustomFields();

    public function getOptions();
}
