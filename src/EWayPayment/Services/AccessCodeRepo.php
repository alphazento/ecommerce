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
            $this->ewayApi = Rapid::createClient(               
                'F9802CbZzvjeQbx6lSFPZO3N/KuFQdqEzZk/yKOGJDuFDQCgiUgGS9kxhFeSbz4F2uteP/', //api key
                'jM2RMxqq', //secret
                Client::MODE_SANDBOX,
                app('log')
            );
        }
        return $this->ewayApi;
    }

    protected function prepareParams($reference) {
        $customer = [
            'FirstName' => 'Tony',
            'LastName' => 'Chen',
            'Title' => 'Prof',
            'Street1'=> '1 bc',
            'Street2'=> '',
            'City' => 'Sydney',
            'State' => 'NSW',
            'PostalCode' => '2000',
            'Country' => 'AU',
            'IsActive'=> '1',
            'Email'=> 'tony@tonercity.com.au',
            'Phone' => '0222222222',
            'Mobile' => '0222222222',
            // 'RedirectUrl' => 'http://alphazento.local.test/rest/v1/payment/postsubmit/ewaypayment'
            'RedirectUrl' => "http://localhost:3000/paymentcallback/ewaypayment"
        ];
        $transaction = [
            // 'Customer' => $customer,
            'TransactionType' => TransactionType::MOTO,
            'Payment' => [
                'TotalAmount' => 50,
                'InvoiceReference' => $reference,
            ]
        ];

        $transaction = array_merge($transaction, $customer);
        return ClassValidator::getInstance('Eway\Rapid\Model\Transaction', $transaction);
    }

    public function requestNewCode() {
        $ref = sprintf('T%s', time());
        $transaction = $this->prepareParams($ref);
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
}
