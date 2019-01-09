<?php

namespace Zento\Sales\Event\Listener;

use Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\ORM\SalesOrderPayment;
use Zento\Sales\Model\ORM\SalesOrderStatus;

class CreatingOrder extends \Zento\Kernel\Booster\Events\BaseListener
{
    /**
     * @param \Zento\Contracts\Catalog\Model\ShoppingCart $event
     * @return void
     */
    protected function run($event) {
        // \zento_assert($event->shoppingCart);
        // dd($event->shoppingCart);

        $order = new SalesOrder();
        $order->store_id = 1;
        $order->invoice_no = 0;
        $order->status_id = 0;
        $order->coupon_code = $event->shoppingCart['coupon_codes'];
        $order->customer_id = $event->shoppingCart['customer_id'];
        $order->customer_is_guest = !$order->customer_id;
        $order->ext_customer_id = 0;
        $order->ext_order_id = 0;
        $order->customer_note = '';
        $order->applied_rule_ids = '';
        $order->remote_ip = Request::ip();
        $order->applied_rule_ids = '';
        $order->total_item_count = $event->shoppingCart['items_quantity'];
        $order->cart_address_id = $event->shoppingCart['shipping_address_id'];
        $order->cart_id = $event->shoppingCart['id'];
        // $order->total_amount_include_tax = 0;
        $order->base_currency_code = 'AUD';
        $order->order_currency_code = 'AUD';
        $order->save();

        // $this->createShipmentRecord($event->shoppingCart, $order->id);
        return ['success' => true, 'order_id' =>  $order->id];
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

    protected function createShipmentRecord($shoppingCart, $ordeId) {
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

    protected function createPaymentRecord($shoppingCart, $orderId, $paymentMethod) {
        $payment = new SalesOrderPayment();
        $payment->order_id = $orderId;
        $payment->payment_method = $paymentMethod;
        $payment->comment = '';
        $payment->total_due = 0;
        $payment->amount_authorized = 0;
        $payment->amount_paid = 0;
        $payment->amount_refunded = 0;
        $payment->amount_canceled = 0;
    }
}
