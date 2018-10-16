<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCartAddress
{
    public function getId();
    public function getEmail();
    public function getCustomerid();
    public function getFirstName();
    public function getMiddleName();
    public function getLastName();
    public function getCompany();
    public function getAddress1();
    public function getAddress2();
    public function getCity();
    public function getCountry();
    public function getPostalCode();
    public function getState();
    public function getPhone();
}
