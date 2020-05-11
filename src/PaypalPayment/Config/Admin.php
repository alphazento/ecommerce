<?php

namespace Zento\PaypalPayment\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\PaypalPayment\Consts;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig
{

    protected function _registerDashboardMenus()
    {}

    protected function _registerDynamicConfigItemMenus()
    {}

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $groups['sales/paymentgateway'] = function ($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'paypalexpress', [
                'title' => 'PayPal Express',
                'items' => [
                    [
                        'title' => 'Enabled In Front-end',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND,
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_BACKEND,
                    ],
                    [
                        'title' => 'Mode',
                        'ui' => 'config-options-item',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'],
                            ['value' => 'production', 'label' => 'Production'],
                        ],
                        'accessor' => Consts::PAYMENT_GATEWAY_PAYPAL_MODE,
                    ],
                    [
                        'title' => 'Sandbox ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_PAYPAL_CLIENT_ID_BY_MODE, 'sandbox'),
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_PAYPAL_SECRET_BY_MODE, 'sandbox'),
                    ],
                    [
                        'title' => 'Production ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_PAYPAL_CLIENT_ID_BY_MODE, 'production'),
                    ],
                    [
                        'title' => 'Production Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_PAYPAL_SECRET_BY_MODE, 'production'),
                    ],
                    [
                        'title' => 'Paypal Button Styles',
                        'ui' => 'config-json-item',
                        'schema' => [
                            'label' => "config-text-item",
                            'size' => "config-text-item",
                            'shape' => "config-text-item",
                            'color' => "config-text-item",
                        ],
                        'accessor' => Consts::CONFIG_KEY_BUTTON_STYLE,
                    ],
                ],
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data)
    {}

    protected function _registerModelDefines(&$data)
    {}

}
