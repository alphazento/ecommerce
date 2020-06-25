<?php

namespace Zento\BraintreePayment\Services;

use Zento\BraintreePayment\Consts;
use Zento\BraintreePayment\Model\PaymentCapturerV1;
use Zento\PaymentGateway\Interfaces\CapturePaymentResult;

class PaymentMethod implements \Zento\PaymentGateway\Interfaces\IMethod
{
    public function getCode()
    {
        return 'braintree';
    }

    public function getTitle()
    {
        return config(Consts::CONFIG_KEY_TITLE, 'Braintree Checkout');
    }

    public function getIcon()
    {
        return config(Consts::CONFIG_KEY_ICON, '/images/payment/mixcard.png');
    }

    public function canOrder()
    {
        return true;
    }

    public function canAuthorize()
    {
        return true;
    }

    public function canCapture()
    {
        return true;
    }

    public function canCapturePartial()
    {
        return true;
    }

    public function canCaptureOnce()
    {
        return true;
    }

    public function canRefund()
    {
        return true;
    }

    public function canUseInternal()
    {
        return true;
    }

    public function canUseAtFront()
    {
        return config(Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND);
    }

    public function canUseAtAdmin()
    {
        return config(Consts::CONFIG_KEY_ENABLE_FOR_BACKEND);
    }

    public function canUseCheckout()
    {
        return true;
    }

    public function canEdit()
    {
        return true;
    }

    public function canFetchTransactionInfo()
    {
        return true;
    }

    public function canUseForCountry($country)
    {
        return true;
    }

    public function canUseForCurrency($currencyCode)
    {
        return true;
    }

    public function canReviewPayment()
    {
        return true;
    }

    public function validate()
    {
        return true;
    }

    public function authorize($payment_data)
    {
        return true;
    }

    public function prepare($params)
    {
        return [];
    }

    /**
     * Base on different payment method,
     *
     * @param array $data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data): \Zento\PaymentGateway\Interfaces\CapturePaymentResult
    {
        $version = $payment_data['version'] ?? 'v1';
        $returns = [];
        switch ($version) {
            case 'v1':
                $returns = (new PaymentCapturerV1)->execute($payment_data);
                break;
            default:
                break;
        }
        $success = $returns['success'] ?? false;
        $extTransactionId = $success ? $returns['transaction_id'] : 0;
        $totalAmount = 0;
        if ($success && ($returns['data']->transaction ?? false)) {
            $totalAmount = $returns['data']->transaction->amount;
        } else {
            $success = false;
        }

        return (new CapturePaymentResult($this->getCode(), $extTransactionId, $totalAmount, $payment_data['payment']))
            ->success($success);
    }

    public function prepareForClientSide($clientType = 'web')
    {
        switch ($clientType) {
            case 'web':
                return $this;
                break;
            case 'vue':
                return $this->prepareForVue();
                break;
        }
    }

    protected function prepareForVue()
    {
        // $url = (string) (route('payment.capture', ['method' => $this->getCode()]));
        return [
            'name' => $this->getCode(),
            'title' => $this->getTitle(),
            'component' => 'braintree-card',
            'withCards' => false,
            'image' => $this->getIcon(),
        ];
    }
}
