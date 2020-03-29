<?php

namespace Zento\PaypalPayment\Services;

use Zento\PaypalPayment\Consts;

use Zento\PaypalPayment\Model\PaymentCapturerV1;
use Zento\PaypalPayment\Model\PaymentCapturerV2;
use Zento\PaypalPayment\Model\PaymentPrimer;
use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;
use Zento\PaymentGateway\Interfaces\CapturePaymentResult;

class PaymentMethod implements \Zento\PaymentGateway\Interfaces\Method {
    public function getCode() {
        return 'paypalexpress';
    }

    public function getTitle(){
        return config(Consts::CONFIG_KEY_TITLE, 'Paypal Express Checkout');
    }

    public function getIcon() {
        return config(Consts::CONFIG_KEY_ICON);
    }

    public function canOrder() {
        return true;
    }

    public function canAuthorize(){
        return true;
    }

    public function canCapture() {
        return true;
    }

    public function canCapturePartial() {
        return true;
    }

    public function canCaptureOnce() {
        return true;
    }
    
    public function canRefund() {
        return true;
    }

    public function canUseInternal() {
        return true;
    }

    public function canUseAtFront() {
        return config(Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND);
    }

    public function canUseAtAdmin() {
        return config(Consts::CONFIG_KEY_ENABLE_FOR_BACKEND);
    }

    public function canUseCheckout() {
        return true;
    }

    public function canEdit() {
        return true;
    }

    public function canFetchTransactionInfo() {
        return true;
    }

    public function canUseForCountry($country) {
        return true;
    }

    public function canUseForCurrency($currencyCode) {
        return true;
    }

    public function canReviewPayment() {
        return true;
    }

    public function validate() {
        return true;
    }

    public function authorize($payment_data) {
        return true;
    }

    public function prepare($params) {
        // return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart("104b47b8-0f10-4669-9e02-b04c0daacf58"));
        return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart($params['cart_id']));
    }

    /**
     * Base on different payment method, 
     *
     * @param array $data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data): \Zento\PaymentGateway\Interfaces\CapturePaymentResult {
        $version = $payment_data['version'] ?? 'v1';
        $returns = [];
        switch($version) {
            case 'v1' :
                $returns = (new PaymentCapturerV1)->execute($payment_data['payment']);
                break;
            case 'v2' :
                $returns = (new PaymentCapturerV2)->execute($payment_data['payment']);
        }

        $success = $returns['success'] ?? false;
        $extTransactionId = $success ? $returns['transaction_id'] : 0;
        $totalAmount =  0;
        if ($success && ($returns['data']['transactions'] ?? false)) {
            $totalAmount = $returns['data']['transactions'][0]['amount']['total'];
        } else {
            $success = false;
        }

        return (new CapturePaymentResult($this->getCode(), $extTransactionId, $totalAmount, $payment_data['payment']))
            ->success($success);
    }

    public function prepareForClientSide($clientType = 'web') {
        switch($clientType) {
            case 'web':
                return $this;
                break;
            case 'vue': 
                return $this->prepareForVue();
                break;
        }
    }

    protected function prepareForVue() {
        $url = (string)(route('payment.capture', ['method' => $this->getCode() ]));
        $mode = config(Consts::PAYMENT_GATEWAY_PAYPAL_MODE);
        $clientId = config(sprintf(Consts::PAYMENT_GATEWAY_PAYPAL_CLIENT_ID_BY_MODE, $mode));
        return [
            'name' => $this->getCode(),
            'title' => $this->getTitle(),
            'component' => 'paypal-card',
            'withCards' =>false,
            'image' => [
                'src' => $this->getIcon(),
            ],
            'configs' => [
                'mode' => $mode,
                'currency' => config(\Zento\StoreFront\Consts::CURRENCY),
                'credentials' => [
                    'sandbox' => $mode === 'sandbox' ? $clientId : '',
                    'production'  => $mode === 'sandbox' ? '' : $clientId
                ],
                'style' => json_decode(config(Consts::CONFIG_KEY_BUTTON_STYLE, '{}')),
                'params' => [
                    'capture_url' => str_replace('https:', 'http:', $url)
                ]
            ]
        ];
    }
}