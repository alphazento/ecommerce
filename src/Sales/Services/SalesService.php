<?php

namespace Zento\Sales\Services;

use DB;
use Request;
use ShareBucket;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Zento\Customer\Model\ORM\Customer;
use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\OrderNumberGenerator;
use Zento\Sales\Model\ORM\SalesOrderStatus;
use Zento\Sales\Model\ORM\PaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class SalesService
{
  public function placeOrder(string $pay_id, $is_backorder = false) 
  {
    if ($transaction = PaymentTransaction::where('pay_id', '=', $pay_id)->first()) {
        $quote = $transaction->quote;
        if ($order = $transaction->order) {
          if (!$order->active) {
            $order = null;
          }
        }
        $quote = $transaction->quote;
        $customer_id = $quote->customer_id;
        $is_guest = 0;
        if (empty($customer_id)) {
          $customer = Customer::findOrCreateByEmail($quote->email);
          $customer_id = $customer->id;
          $is_guest = 1;
        }
        $order = $order ? $order : SalesOrder::create([
          'store_id' => ShareBucket::get('store_id', 0),
          'order_number' => app(OrderNumberGenerator::class)->generate(0),
          'invoice_id' => 0,
          'payment_transaction_id' => $transaction->id,
          'status_id' => SalesOrderStatus::PENDING,
          'is_backorder' => $is_backorder,
          // 'amend_from',
          // 'resend_from',
          'customer_id' => $customer_id,
          'customer_note' => '',
          'is_guest' => $is_guest,
          'remote_ip' => $quote->client_ip ?? Request::ip()
        ]);

        $transaction->update(['order_id' => $order->id]);
        $address = SalesAddress::createFromCart($quote);
        $this->createShipmentRecord($order->id, $customer_id, $address->id);
        return $order;
    }
    return null;
  }

  protected function createShipmentRecord($orde_id, $customer_id, $address_id) {
    $shipment = new SalesShipment();
    $shipment->order_id = $orde_id;
    $shipment->customer_id = $customer_id
    $shipment->sales_address_id = $address_id;
    $shipment->shipment_status_id = 0;
    $shipment->shipping_carrier_id = 0;
    $shipment->shipping_method_id = 0;
    $shipment->shipment_instruction = '';
    $shipment->save();
  }
}