<?php

namespace Zento\Shipment\Services;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShipmentService 
{
  protected $methods = [];
  protected $methodInited = false;
  public function registerMethod($code, \Zento\Contracts\Shipment\Method $method) {
    $this->methods[$code] = $method;
  }

  protected function initMethods() {
    if (!$this->methodInited) {
      uasort($this->methods, function($a, $b) {
        if ($a->sort_order == $b->sort_order) {
          return 0;
        }
        return ($a->sort_order < $b->sort_order) ? -1 : 1;
      });
      $this->methodInited = true;
    }
    return $this;
  }

  public function estimate(\Zento\Contracts\Catalog\Model\ShoppingCart $cart,
      \Zento\Contracts\Address $shipping_address, 
       $customer,
       $arrivalDate) {
    zento_assert($cart);
    zento_assert($shipping_address);
    
    $results = [];
    $this->initMethods();

    foreach ($this->methods as $code => $method) {
      if ($method->active_frontend) {
        if ($ret = $method->estimate($cart, $shipping_address, $customer, $arrivalDate)) {
          if ($ret->available) {
            $results[$code] = $ret;
          }
        }
      }
    }
    return array_values($results);
  }

  public function getShippingMethod($code) {
    return $this->initMethods()->methods[$code];
  }
}