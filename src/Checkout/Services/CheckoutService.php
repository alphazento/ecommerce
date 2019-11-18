<?php

namespace Zento\Checkout\Services;

use DB;
use Store;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IPaymentTransaction;

class CheckoutService
{
    /**
     * create order method
     *
     * @param \Zento\PaymentGateway\Model\PaymentTransaction $paymentTransaction
     * @param \Zento\Contracts\Interfaces\Catalog\IShoppingCart $shoppingCart
     * @return void
     */
    public function draftOrder(IPaymentTransaction $paymentTransaction, IShoppingCart $shoppingCart) {
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