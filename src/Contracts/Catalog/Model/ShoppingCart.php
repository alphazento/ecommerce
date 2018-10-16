<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCart
{
    public function getId();

    public function getEmail();

    public function getMode();

    public function getStatus();

    public function shipToBillingAddress();

    public function getBillingAddress();

    public function getShippingAddress();

    public function getInvoiceNumber();

    public function getPaymentMethod();

    public function getCurrency();

    public function getTotalWeight();

    public function getTotal();

    public function getItems();

    public function getItemCount();
}
