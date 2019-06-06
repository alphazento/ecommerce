<?php

namespace Zento\Sales\Services;

use DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesOrderPayment;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\OrderNumberGenerator;
use Zento\Sales\Model\ORM\SalesOrderStatus;

class SalesService
{
  public function placeOrder(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, 
    $payment, 
    $ship_method_code, 
    $shipping_carrier = '',
    $shipping_fee = '',
    $customer_note = '') {
      $customer = $cart->customer;
      $order = SalesOrder::create([
        'order_number' => app(OrderNumberGenerator::class)->generate(0),
        'is_backorder' => 0,
        'invoice_no' => 0,
        'store_id' => 0,
        'status_id' => SalesOrderStatus::PENDING,
        'coupon_code' => $cart->coupon_code,
        'customer_id' => $cart->customer_id,
        'customer_is_guest' => $customer ? $customer->isGuest() : 0,
        'ext_customer_id' => 0,
        'ext_order_id' => 0,
        'customer_note' => $customer_note,
        'applied_rule_ids' => $cart->applied_rule_ids,
        'remote_ip' => $cart->client_ip,
        'total_item_count' => $cart->items_count,
        'cart_address_id' => $cart->shipping_address_id,
        'cart_id' => $cart->id,
        'total_amount_include_tax' => $cart->total
      ]);

      $cartBillingAddress = $cart->billing_address ? $cart->billing_address : $cart->shipping_address;
      $billing_address = new SalesAddress($cartBillingAddress->getAttributes());
      $billing_address->id = null;
      $billing_address->save();

      if ($cart->ship_to_billingaddesss) {
        $shipping_address = $billing_address;
      } else {
        $shipping_address = new SalesAddress($cart->shipping_address->getAttributes());
        $shipping_address->id = null;
        $shipping_address->save();
      }

      // $shipment = SalesShipment::create([
      //   'order_id' => $order->id,
      //   'customer_id' => $cart->customer_id,
      //   'shipment_status' => 0,
      //   'shipping_address_id' => $shipping_address->id,
      //   'billing_address_id' => $billing_address->id,
      //   'shipping_method' => 0,
      //   'shipping_carrier' => 0,
      //   'shipment_instruction' => 0,
      //   'total_weight' => 0,
      //   'total_qty' => $cart->items_quantity,
      // ]);

      // $shipment->save();

      $payment = new SalesOrderPayment([
        'order_id' => $order->id,
        'comment' => '',
        'total_due' => 0,
        'amount_authorized' => $cart->total,
        'amount_paid' => $cart->total,
        'amount_refunded' => 0,
        'amount_canceled' => 0,
      ]);
      $payment->order_id = $order->id;
      $payment->save();
      // $payment->storePaymentItems($cart);

      return $order;
  }
}