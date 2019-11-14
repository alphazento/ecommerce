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

    protected function getApiClient() {
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
            'name' => $shippingAddress['name'],
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
            'RedirectUrl' => "/paymentcallback/ewaypayment"
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

    /**
     * request a new access code from eway server
     *
     * @param array $shoppingCart
     * @return void
     */
    public function requestNewCode($shoppingCart) {
        $ref = $shoppingCart['guid'];
        $transaction = $this->prepareParams($shoppingCart, $ref);
        $response = $this->getApiClient()->createTransaction(
            ApiMethod::TRANSPARENT_REDIRECT,
            $transaction
        );
        try {
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
                return [false, ['response' => $response->toArray(), 'messages' => $this->parseErrors($response->Errors)]];
            }
        } catch (\Exception $e) {
            return [false, ['response' => $response->toArray(), 'messages' => ['Z9999' => $e->getMessage()]]];
        }
    }

   /**
    * check an access code's status
    *
    * @param string $accesscode
    * @return array with indicator if success and messages
    */
    public function checkAccessCode($accesscode) {
        $response = $this->getApiClient()->queryAccessCode($accesscode);

        $messages = array_merge($this->parseErrors($response->ResponseMessage), $this->parseErrors($response->Errors));
        if (isset($response->AccessCode) && $response->AccessCode != $accesscode) {
            return [false, $response->toArray(), $messages];
        }

        if ($response->ResponseMessage == 'S5099' && !$response->AuthorisationCode) {
            return [false, $response->toArray(), $messages];
        }

        if ($response->TransactionStatus
            && $response->TransactionID
            && in_array($response->ResponseMessage, $this->success_response_messages))
        {
            return [true, $response->toArray(), $messages];
        }
        return [false, $response->toArray(), $messages];
    }

    /**
     * parse eway error code to message.
     *
     * @param array|string $errors
     * @return array messages
     */
    protected function parseErrors($errors) {
        if (empty($errors)) {
            return [];
        }
        if (!is_array($errors)) {
            $errors = [$errors];
        }
        $messages = [];
        foreach($errors as $error) {
            $messages[$error] = Rapid::getMessage($error);
        }
        return $messages;
    }
}
