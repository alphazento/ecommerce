<?php

namespace Zento\BraintreePayment\Model;

use Braintree\Gateway;
use Zento\BraintreePayment\Consts;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;

class PaymentCapturerV1
{
    public function execute($reqData)
    {
        if ($nonce = ($reqData['payment']['nonce'] ?? false)) {
            $result = $this->createTransaction($reqData);
            return ['success' => $result->success,
                'data' => $result,
                'transaction_id' => $result->transaction->id,
            ];
        }

        return ['success' => false, 'data' => [$reqData], 'messages' => $this->errors];
    }

    /**
     * @param QuoteContract $quote
     * @param array $reqData
     * @return \Braintree\Result\Error|\Braintree\Result\Successful
     */
    protected function createTransaction($reqData)
    {
        $quote = $reqData['quote'];

        $shippingAddress = ShoppingCartAddress::find($quote['shipping_address_id']);
        $nameParts = explode(',', $shippingAddress->name);

        $payload = [
            'amount' => $quote['total'],
            'paymentMethodNonce' => $reqData['payment']['nonce'],
            /**
             * Send shipping address in order to be eligible for PayPal Seller Protection.
             * @link https://developers.braintreepayments.com/guides/paypal/server-side/php#seller-protection
             * @link https://www.paypal.com/us/webapps/mpp/security/seller-protection
             * Address format reference:
             * @link https://developers.braintreepayments.com/reference/request/transaction/sale/php#full-example
             */
            'shipping' => [
                'firstName' => $nameParts[0],
                'lastName' => $nameParts[1] ?? '',
                'company' => $shippingAddress->company,
                'streetAddress' => $shippingAddress->street1,
                'extendedAddress' => $shippingAddress->street2,
                'locality' => $shippingAddress->city,
                'region' => $shippingAddress->state,
                'postalCode' => $shippingAddress->postal_code,
                'countryCodeAlpha2' => $shippingAddress->country,
            ],
            'customer' => [
                'firstName' => $nameParts[0],
                'lastName' => $nameParts[1] ?? '',
                'email' => $quote['email'],
                'company' => $shippingAddress->company,
                'phone' => $shippingAddress->phone,
            ],
            'options' => [
                'submitForSettlement' => true,
            ],
        ];

        if ($reqData['payment']['deviceData'] ?? false) {
            $payload['deviceData'] = $reqData['payment']['deviceData'];
        }

        return $this->getGateway()->transaction()->sale($payload);
    }

    public function getGateway()
    {
        return new Gateway([
            'environment' => config(Consts::PAYMENT_GATEWAY_BRAINTREE_MODE),
            'merchantId' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_MERCHANT_ID_BY_MODE, 'sandbox')),
            'publicKey' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_CLIENT_ID_BY_MODE, 'sandbox')),
            'privateKey' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_SECRET_BY_MODE, 'sandbox')),
        ]);
    }
}
