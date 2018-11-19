<?php

use \Zento\FreeShipping\Model\ShippingMethod;

if ($method = new ShippingMethod()) {
  $method->method_code = \Zento\FreeShipping\Model\ShippingMethod::CODE;
  $method->title = 'Fixed';
  $method->active_frontend = true;
  $method->active_admin = true;
  $method->description = 'Fixed fee under Threshold, free shipping more then Threshold';
}