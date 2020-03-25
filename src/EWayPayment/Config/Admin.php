<?php

namespace Zento\EwayPayment\Config;

use Zento\EWayPayment\Consts;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    protected function _registerDashboardMenus() {}
    protected function _registerDynamicConfigItemMenus() {}

    protected function _registerDynamicConfigItemGroups( &$data) {
        $data['sales/paymentgateway'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'eWay',  [
                'title' => 'eWay Transparent',
                'items' => [
                    [
                        'title' => 'Enabled In Front-end',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::CONFIG_KEY_ENABLE_FOR_BACKEND
                    ],
                    [
                        'title' => 'Display Title',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_TITLE
                    ],
                    [
                        'title' => 'Mode',
                        'ui' => 'config-options-item',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'], 
                            ['value' => 'production', 'label' => 'Production']
                        ],
                        'accessor' => Consts::PAYMENT_GATEWAY_EWAY_MODE
                    ],
                    [
                        'title' => 'Sandbox ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_EWAY_CLIENT_ID_BY_MODE, 'sandbox')
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_EWAY_SECRET_BY_MODE, 'sandbox')
                    ],
                    [
                        'title' => 'Production ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_EWAY_CLIENT_ID_BY_MODE, 'production')
                    ],
                    [
                        'title' => 'Production Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => sprintf(Consts::PAYMENT_GATEWAY_EWAY_SECRET_BY_MODE, 'production')
                    ]
                ]
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerModelDefines(&$data){}
    
}