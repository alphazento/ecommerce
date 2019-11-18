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
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class SalesService
{
  public function placeOrder(IShoppingCart $cart, 
    $payment, 
    $ship_method_code, 
    $shipping_carrier = '',
    $shipping_fee = '',
    $customer_note = '') 
  {
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
        'total_item_count' => $cart->items_quantity,
        'cart_address_id' => $cart->shipping_address_id,
        'cart_id' => $cart->id,
        'total_amount_include_tax' => $cart->total
      ]);
      // $this->createPaymentRecord($order->id, $payment);
      $this->updatePaymentRecord($order->id, $payment);

      // $cartBillingAddress = $cart->billing_address ? $cart->billing_address : $cart->shipping_address;
      // $billing_address = new SalesAddress($cartBillingAddress->getAttributes());
      // $billing_address->id = null;
      // $billing_address->save();

      // if ($cart->ship_to_billingaddesss) {
      //   $shipping_address = $billing_address;
      // } else {
      //   $shipping_address = new SalesAddress($cart->shipping_address->getAttributes());
      //   $shipping_address->id = null;
      //   $shipping_address->save();
      // }

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
      return $order;
  }

  protected function createSalesAddressRecord($shippingAddress) {
    $id = $shippingAddress['id'];
    unset($shippingAddress['id']);
    unset($shippingAddress['hash']);
    $address = new SalesAddress($shippingAddress->toArray());
    $address->save();
    $shippingAddress['id'] = $id;
    return $address->id;
  }

  protected function createShipmentRecord($ordeId, $shoppingCart) {
    $shipment = new SalesShipment();
    $shipment->order_id = $ordeId;
    $shipment->customer_id = $shoppingCart['customer_id'];
    $shipment->shipment_status = 0;
    $shipment->shipping_address_id = $this->createSalesAddressRecord($shoppingCart['shipping_address']);
    //    $shipment->billing_address_id = $this->storeSalesAddress($shoppingCart['shipping_address']); //ship_to_billingaddesss
    $shipment->shipping_method = '';
    // $shipment->shipping_carrier = $shipping_carrier;
    $shipment->shipment_instruction = '';
    // $table->decimal('total_weight', 12, 4)->nullable();
    // $table->decimal('total_qty', 12, 4)->nullable();
    // $table->boolean('can_ship_partially')->default(0);
    // $table->smallInteger('can_ship_partially_item')->unsigned()->nullable();
    $shipment->save();
  }

  protected function createPaymentRecord($order_id, $paymentTransaction) {
    // $comment = $paymentTransaction->comment;
    $payment_method = $paymentTransaction->payment_method;
    $payment_transaction_id = $paymentTransaction->id;
    $amount_due = $paymentTransaction->amount_due;
    $amount_authorized = $paymentTransaction->amount_authorized;
    $amount_paid = $paymentTransaction->amount_paid;
    $amount_refunded = $paymentTransaction->amount_refunded;
    $amount_canceled = $paymentTransaction->amount_canceled;
    $payment = new SalesOrderPayment(compact('order_id',
      'order_id',
      'comment',
      'payment_method',
      'payment_transaction_id',
      'amount_due',
      'amount_authorized',
      'amount_paid',
      'amount_refunded',
      'amount_canceled'));
    $payment->save();
  }
}