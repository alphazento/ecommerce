<?php

namespace Zento\Checkout\Services;

use DB;
use Store;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Contracts\Catalog\Model\ShoppingCart;
use Zento\PaymentGateway\Model\PaymentTransaction;

class CheckoutService
{
    /**
     * create order method
     *
     * @param \Zento\PaymentGateway\Model\PaymentTransaction $paymentTransaction
     * @param \Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart
     * @return void
     */
    public function draftOrder(PaymentTransaction $paymentTransaction, ShoppingCart $shoppingCart) {
        // \zento_assert($paymentTransaction);
        \zento_assert($shoppingCart);
        $eventResult = (new \Zento\Checkout\Event\DraftOrder(
                $shoppingCart, 
                $paymentTransaction)
            )->fireUntil();
        if ($eventResult->isSuccess()) {
            (new \Zento\Checkout\Event\OrderCreated(
                $eventResult->getData('order'), 
                $shoppingCart)
            )->fire();
        }
        return $eventResult;
    }
}