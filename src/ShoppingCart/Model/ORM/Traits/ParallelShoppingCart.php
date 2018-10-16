<?php

namespace Zento\ShoppingCart\Model\ORM\Traits;

trait ParallelShoppingCart
{
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->id;
    }

    public function getMode() {
        return $this->mode;
    }

    public function getStatus() {
        return $this->status;
    }

    public function shipToBillingAddress() {
        return $this->ship_to_billingaddesss;
    }

    public function getBillingAddress() {
        return $this->billing_address;
    }

    public function getShippingAddress() {
        return $this->shipping_address;
    }

    public function getInvoiceNumber() {
        return $this->invoice_number;
    }

    public function getPaymentMethod() {
        return $this->payment_method;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getTotalWeight() {
        return $this->total_weight;
    }

    public function getTotal() {
        return $this->total_weight;
    }

    public function getItems() {
        return $this->items;
    }

    public function getItemCount() {
        return $this->items_count;
    }
}