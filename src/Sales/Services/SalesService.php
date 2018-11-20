<?php

namespace Zento\Sales\Services;

use DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesOrderPayment;

class SalesService
{
  public function placeOrder(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $payment, $customer_note = '') {
    $order = SalesOrder::create([
      'invoice_no' => 0,
      'store_id' => 0,
      'status_id' => 0,
      'coupon_code' => $cart->coupon_code,
      'customer_id' => $cart->customer_id,
      'customer_is_guest' => 1, #$cart->customer->isGuest(),
      'ext_customer_id' => 0,
      'ext_order_id' => 0,
      'customer_note' => $customer_note,
      'applied_rule_ids' => $cart->applied_rule_ids,
      'remote_ip' => '',
      'total_item_count' => $cart->items_count,
      'cart_address_id' => $cart->shipping_address_id,
      'cart_id' => $cart->id,
      'total_amount_include_tax' => $cart->total,
      'base_currency_code' => 'USD',
      'order_currency_code' => 'AUD',
      'base_to_order_currency_rate' => "1.3"
    ]);
    return $order;
  }
}