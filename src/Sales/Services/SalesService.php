<?php

namespace Zento\Sales\Services;

use Request;
use ShareBucket;
use Zento\Customer\Model\ORM\Customer;
use Zento\Sales\Model\OrderNumberGenerator;
use Zento\Sales\Model\ORM\PaymentTransaction;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesOrderItem;
use Zento\Sales\Model\ORM\SalesOrderProduct;
use Zento\Sales\Model\ORM\SalesOrderStatus;
use Zento\Sales\Model\ORM\SalesShipment;

class SalesService
{
    public function placeOrder(string $pay_id, $is_backorder = false)
    {
        if ($transaction = PaymentTransaction::where('pay_id', '=', $pay_id)->first()) {
            $quote = $transaction->quote;
            if ($order = $transaction->order) {
                return $order;
            }
            $quote = $transaction->quote;
            $customer_id = $quote->customer_id;
            $is_guest = 0;
            if (empty($customer_id)) {
                $customer = Customer::findOrCreateByEmail($quote->email);
                $customer_id = $customer->id;
                $is_guest = 1;
            }
            $order = SalesOrder::create([
                'store_id' => ShareBucket::get('store_id', 0),
                'order_number' => app(OrderNumberGenerator::class)->generate(0),
                'invoice_id' => 0,
                'status_id' => SalesOrderStatus::PENDING,
                'is_backorder' => $is_backorder,
                // 'amend_from',
                // 'resend_from',
                'customer_id' => $customer_id,
                'customer_note' => '',
                'is_guest' => $is_guest,
                'remote_ip' => $quote->client_ip ?? Request::ip(),
                'subtotal' => $quote->subtotal,
                'total' => $quote->total,
                'tax_amount' => $quote->tax_amount,
            ]);
            $transaction->update(['order_id' => $order->id]);
            $address = SalesAddress::createFromCart($quote);
            $this->createShipmentRecord($order->id, $customer_id, $address ? $address->id : 0);

            SalesOrderProduct::recordProductsFromOrderQuote($order->id, $quote);
            SalesOrderItem::recordItemsFromOrderQuote($order->id, $quote);
            return $order;
        }
        return null;
    }

    protected function createShipmentRecord($orde_id, $customer_id, $address_id)
    {
        $shipment = new SalesShipment();
        $shipment->order_id = $orde_id;
        $shipment->sales_address_id = $address_id;
        $shipment->shipment_status_id = 0;
        $shipment->shipping_carrier_id = 0;
        $shipment->shipping_method_id = 0;
        $shipment->shipment_instruction = '';
        $shipment->save();
    }

}
