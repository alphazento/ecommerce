<?php

namespace Zento\Sales\Services;

use DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\OrderNumberGenerator;
use Zento\Sales\Model\ORM\SalesOrderStatus;
use Zento\Sales\Model\ORM\PaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class SalesService
{
  public function placeOrder(string $pay_id, $guest_checkout = true, $customer_note = '', $client_ip = null) 
  {
    if ($transaction = PaymentTransaction::where('pay_id', '=', $pay_id)->first()) {
        if ($order = $transaction->order) {
          if (!$order->active) {
            $order = null;
          }
        }
        $quote = $transaction->quote;
        $order = $order ? $order : SalesOrder::create([
          'order_number' => app(OrderNumberGenerator::class)->generate(0),
          'is_backorder' => 0,
          'invoice_no' => 0,
          'store_id' => 0,
          'status_id' => SalesOrderStatus::PENDING,
          'guest_checkout' => $guest_checkout ? 1 : 0,
          'customer_note' => $customer_note,
          'remote_ip' => $client_ip,
          'payment_transaction_id' => $transaction->id
        ]);
    }
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
}