<?php

namespace Zento\EWayPayment\Services;

use Session;
use Closure;
use Eway\Rapid;
use Eway\Rapid\Client;
use Eway\Rapid\Enum\ApiMethod;
use Eway\Rapid\Model\Response\AbstractResponse;
use Eway\Rapid\Enum\TransactionType;
use Eway\Rapid\Validator\ClassValidator;
use eWayAPI;
use Request;
use Carbon\Carbon;

class AccessCodeRepo {
    const EWAY_NETWORK_ERR = 'eway_network_error';
    const ACCESSCODE_INVALID = 'accesscode_invalid';
    const ACCESSCODE_READY = 'accesscode_ready';
    const ACCESSCODE_COMPLETED = 'accesscode_complete';
    const ACCESSCODE_FAIL = 'accesscode_fail';
    const ACCESSCODE_VALIDATE_FAIL = 'accesscode_validate_fail';

    const SANDBOX_ACCESSCODE_API_ENTRY =  'payment/eway/sandbox/api_accesscode_url';
    const PRODUCTION_ACCESSCODE_API_ENTRY =  'payment/eway/production/api_accesscode_url';

    protected $lastRemoteResponse;
    protected $lastRemoteStatus;
    private $success_response_messages = [
        'A2000',
        'A2008',
        'A2010',
        'A2011',
        'A2016'
    ];

    protected $ewayApi = null;

    public function getApiClient() {
        if (!$this->ewayApi) {
            $mode = config('paymentgateway.eway.mode', 'sandbox');
            $this->ewayApi = Rapid::createClient(
                config(sprintf('paymentgateway.eway.%s.client_id', $mode)),
                config(sprintf('paymentgateway.eway.%s.secret', $mode)),
                $mode,
                app('log')
            );
        }
        return $this->ewayApi;
    }

    protected function prepareParams($shoppingCart, $reference) {
        $shippingAddress = $shoppingCart['shipping_address'];
        $customer = [
            'FirstName' => $shippingAddress['firstname'],
            'LastName' => $shippingAddress['lastname'],
            'Title' => 'Prof',
            'Street1'=> $shippingAddress['address1'],
            'Street2'=> $shippingAddress['address2'],
            'City' => $shippingAddress['city'],
            'State' => $shippingAddress['state'],
            'PostalCode' =>$shippingAddress['postal_code'],
            'Country' => 'AU',
            'IsActive'=> $shippingAddress['is_active'],
            'Email'=> $shoppingCart['email'],
            'Phone' => $shippingAddress['phone'],
            'Mobile' => $shippingAddress['phone'],
            // 'RedirectUrl' => 'http://alphazento.local.test/rest/v1/payment/postsubmit/ewaypayment'
            'RedirectUrl' => "http://localhost:3000/paymentcallback/ewaypayment"
        ];
        $transaction = [
            'TransactionType' => TransactionType::MOTO,
            'Payment' => [
                'TotalAmount' => $shoppingCart['total'] * 100,
                'InvoiceReference' => $reference,
            ]
        ];

        $transaction = array_merge($transaction, $customer);
        return ClassValidator::getInstance('Eway\Rapid\Model\Transaction', $transaction);
    }

    public function requestNewCode($shoppingCart) {
        $ref = $shoppingCart['guid'];
        $transaction = $this->prepareParams($shoppingCart, $ref);
        $response = $this->getApiClient()->createTransaction(
            ApiMethod::TRANSPARENT_REDIRECT,
            $transaction
        );
        if (!empty($response->AccessCode)) {
            return [
                true,
                [
                    'access_code' => $response->AccessCode,
                    'ref'=>$ref,
                    'action_url' => $response->FormActionURL
                ]
            ];
        } else {
            return [false, $response->Errors];
        }
    }

    /**
    *  asset access code should be ...
    */
    public function checkAccessCode($accesscode) {
        $response = $this->getApiClient()->queryAccessCode($accesscode);

        if ($response->AccessCode != $accesscode) {
            return ['status' => 420, 'data' => self::ACCESSCODE_INVALID];
        }

        if ($response->ResponseMessage == 'S5099' && !$response->AuthorisationCode) {
            return ['status' => 200, 'data' => self::ACCESSCODE_READY];
        }

        if ($response->TransactionStatus
            && $response->TransactionID
            && in_array($response->ResponseMessage, $this->success_response_messages))
        {
            return ['status' => 201, 'data' => self::ACCESSCODE_COMPLETED];
        }
        return [
            'status' => 420, 
            'data' => self::ACCESSCODE_FAIL, 
            'ResponseMessage' => $response->ResponseMessage
        ];
    }
}
