<?php

namespace Zento\BraintreePayment\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\BraintreePayment\Consts;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig
{
    protected function _registerDashboardMenus()
    {}

    protected function _registerDynamicConfigItemMenus()
    {}

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $data['sales/payment-gateway'] = function ($groupTag) {
            AdminConfigurationService::registerGroup($groupTag,
                [
                    'Braintree' => [
                        'text' => 'Braintree',
                        'items' => [
                            [
                                'text' => 'Enabled In Front-end',
                                'ui' => 'config-boolean-item',
                                'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND,
                            ],
                            [
                                'text' => 'Enabled In Admin Panel',
                                'ui' => 'config-boolean-item',
                                'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_BACKEND,
                            ],
                            [
                                'text' => 'Mode',
                                'ui' => 'config-options-item',
                                'options' => [
                                    ['value' => 'sandbox', 'label' => 'Sandbox'],
                                    ['value' => 'production', 'label' => 'Production'],
                                ],
                                'accessor' => Consts::PAYMENT_GATEWAY_BRAINTREE_MODE,
                            ],
                            [
                                'text' => 'Merchant ID',
                                'ui' => 'config-longtext-item',
                                'accessor' => sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_MERCHANT_ID_BY_MODE, 'sandbox'),
                            ],
                            [
                                'text' => 'Sandbox ClientID',
                                'ui' => 'config-longtext-item',
                                'accessor' => sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_CLIENT_ID_BY_MODE, 'sandbox'),
                            ],
                            [
                                'text' => 'Sandbox Secret',
                                'ui' => 'config-longtext-item',
                                'accessor' => sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_SECRET_BY_MODE, 'sandbox'),
                            ],
                            [
                                'text' => 'Production ClientID',
                                'ui' => 'config-longtext-item',
                                'accessor' => sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_CLIENT_ID_BY_MODE, 'production'),
                            ],
                            [
                                'text' => 'Production Secret',
                                'ui' => 'config-longtext-item',
                                'accessor' => sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_SECRET_BY_MODE, 'production'),
                            ],
                        ],
                    ],
                ]
            );
        };
    }

    protected function _registerDataTableSchemas(&$data)
    {}

    protected function _registerModelDefines(&$data)
    {}

}
