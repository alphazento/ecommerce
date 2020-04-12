<?php

namespace Zento\Shipment\Model;

use Config;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IAddress;
// use Zento\Contracts\Shipment\EstimateResult;
use Zento\Contracts\Interfaces\Shipment\EstimateResult

abstract class ShippingMethod implements \Zento\Contracts\Interfaces\Shipment\IMethod
{
  protected $uqiue_method_name;
  protected $extraAttributes = [];

  /**
   * Dynamically retrieve attributes on the model.
   *
   * @param  string  $key
   * @return mixed
   */
  public function __get($key)
  {
    if (in_array($key, self::PROPERTIES) || in_array($key, $this->extraAttributes)) {
      return Config::get(sprintf('shipment.%s.%s', $this->uqiue_method_name, $key), null);
    }
  }

  /**
   * Dynamically set attributes on the model.
   *
   * @param  string  $key
   * @param  mixed  $value
   * @return void
   */
  public function __set($key, $value)
  {
    if (in_array($key, self::PROPERTIES) || in_array($key, $this->extraAttributes)) {
      Config::save(sprintf('shipment.%s.%s', $this->uqiue_method_name, $key), $value);
    }
  }

  abstract public function estimate(IShoppingCart $cart,
    IAddress $shipping_address, 
    $customer,
    $arrivalDate) : EstimateResult;
}