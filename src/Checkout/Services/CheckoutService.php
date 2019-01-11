<?php

namespace Zento\Checkout\Services;

use DB;
use Store;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\ShoppingCart\Model\ORM\ShoppingCart;

class CheckoutService
{
    /**
     * create order method
     *
     * @param \Zento\PaymentGateway\Interfaces\PaymentDetail $paymentDetail
     * @param \Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart
     * @return void
     */
    public function createOrder(\Zento\PaymentGateway\Interfaces\PaymentDetail $paymentDetail, \Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart) {
        \zento_assert($paymentDetail);
        \zento_assert($shoppingCart);
        $eventResult = (new \Zento\Checkout\Event\CreateOrder(
                $shoppingCart, 
                $paymentDetail)
            )->fireUntil();
        if ($eventResult->isSuccess()) {
            (new \Zento\Checkout\Event\OrderCreated(
                $shoppingCart, 
                $paymentDetail)
            )->fire();
        }
        return $eventResult;
    }
}