<?php

namespace Zento\ShoppingCart\Model\ORM\Traits;

trait ParallelShoppingCartAddress
{
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCustomerid()
    {
        return $this->customer_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
