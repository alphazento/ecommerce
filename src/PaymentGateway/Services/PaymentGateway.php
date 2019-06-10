<?php

namespace Zento\PaymentGateway\Services;

use Closure;
use CheckoutService;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentGateway {
    protected $app;
    protected $methods;
    public function __construct($app) {
        $this->app = $app ?: app();
        $this->method_services = [];
    }

    /**
     * return all payment method services
     *
     * @return array
     */
    public function all() {
        return $this->method_services;
    }

    /**
     * get payment method
     *
     * @param string $serviceName
     * @return \Zento\PaymentGateway\Interfaces\Method
     */
    public function getMethod($serviceName) {
        $serviceName = strtolower($serviceName);
        if (isset($this->method_services[$serviceName])) {
            $service = $this->method_services[$serviceName] ?? null;
            if (is_callable($service)) {
                $this->method_services[$serviceName] = call_user_func_array($service, []);
            }
            return $this->method_services[$serviceName];
        }
        return null;
    }

    /**
     * return all available payment method services
     *
     * @param mixed $quote
     * @param mixed $user
     * @param mixed $shippingAddress
     * @param string $clientType
     * @return array \Zento\PaymentGateway\Interfaces\Method
     */
    public function estimate($quote, $user, $shippingAddress, $clientType = 'web') {
        $availables = [];
        foreach($this->method_services as $serviceName => $instance) {
            $service = $this->getMethod($serviceName);
            // if ($service->isAvailable($quote, $user, $shippingAddress)) {
                $availables[] = $service->prepareForClientSide($clientType);
            // }
        }
        return $availables;
    }

    /**
     * register payment method to paymentgateway 
     *
     * @param string $methodName
     * @param Closure $serviceCreator
     * @return void
     */
    public function registerMethod($methodName, Closure $serviceCreator) {
        $this->method_services[strtolower($methodName)] = $serviceCreator;
        return $this;
    }

    /**
     * eanble a payment method
     *
     * @param string $methodName
     * @return void
     */
    public function enableMethod($methodName) {
        $service = $this->getMethod($methodName);
        $service->enable();
        return $this;
    }

    /**
     * disable a payment method
     *
     * @param string $methodName
     * @return void
     */
    public function disableMethod($methodName) {
        $service = $this->getMethod($methodName);
        $service->disable();
        return $this;
    }

    public function preparePaymentData(string $methodName, \Zento\Contracts\Interfaces\Catalog\IShoppingCart $shoppingCart) {
        if ($method = $this->getMethod($methodName)) {
            \zento_assert($shoppingCart);
            $eventResult = (new \Zento\PaymentGateway\Event\BeforePreparePayment($methodName, $shoppingCart))
                ->fireUntil();
            if ($eventResult->isSuccess())
            {
                return $method->prepare($shoppingCart);
            } else {
                return [false, $eventResult->getData()];
            }
        }
        return [false, 'data' => ['messages'=>['Payment method not support by server.']]];
    }

    public function capturePayment(string $methodName, array $params) {
        if (!isset($params['shopping_cart'])) {
            return [false, ['messages'=>['Parameter error.']]];
        }
        if ($method = PaymentGateway::getMethod($methodName)) {
            $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', $params['shopping_cart']);
            \zento_assert($shoppingCart);
            $eventResult = (new \Zento\PaymentGateway\Event\BeforeCapturePayment($methodName, $shoppingCart))
                ->fireUntil();
            if ($eventResult->isSuccess())
            {
                $paymentResult = $method->capture($params);
                if ($paymentResult->canDraftOrderAfterCapture()) { //payment success
                    $order = CheckoutService::draftOrder($paymentResult->getPaymentTransaction(), $shoppingCart);
                    $order->addData('payment_data', $paymentResult->toArray());
                    return [$order->isSuccess(), $order->getData()];
                } else {
                    return [$paymentResult->isSuccess(), $paymentResult->toArray()];
                }
            } else {
                return [false, $eventResult->getData()];
            }
        } else {
            return [false, ['messages'=>['Payment method not support by server.']]];
        }
    }
}