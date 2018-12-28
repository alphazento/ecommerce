<?php

namespace Zento\PaymentGateway\Services;

use Config;
use Registry;
use Closure;

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
                $availables[] = $service->prepareForClient($clientType);
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

    /**
     * render method view part to page
     *
     * @param string $methodName
     * @return string
     */
    public function renderMethodView($methodName) {
        $service = $this->getMethod($methodName);
        return $service->renderMethodView();
    }
}