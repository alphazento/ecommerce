<?php

namespace Zento\Shipment\Model;

use Config;

abstract class ShippingMethod implements \Zento\Contracts\Shipment\Method
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

  abstract public function estimate(\Zento\Contracts\Catalog\Model\ShoppingCart $cart,
    \Zento\Contracts\Catalog\Model\ShoppingCartAddress $shipping_address, 
    $customer,
    $arrivalDate) : \Zento\Contracts\Shipment\EstimateResult;
}