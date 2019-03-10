<?php

namespace Zento\PaypalPayment\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['Sales/PaymentGateway'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'paypalexpress',  [
                'title' => 'PayPal Express',
                'items' => [
                    [
                        'title' => 'Enabled In Frontend',
                        'type' => 'Switch',
                        'accessor' => 'paymentgateway.paypalexpress.frontend.enabled'
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'type' => 'Switch',
                        'accessor' => 'paymentgateway.paypalexpress.admin.enabled'
                    ],
                    [
                        'title' => 'Mode',
                        'type' => 'SelectBox',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'], 
                            ['value' => 'production', 'label' => 'Production']
                        ],
                        'accessor' => 'paymentgateway.paypalexpress.mode'
                    ]
                ]
            ]);
            AdminService::registerSubgroupToGroup($groupTag, 'paypalexpress', 'sandbox', [
                'title' => 'Sandbox API Settings',
                'items' => [
                    [
                        'title' => 'Sandbox ClientID',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.sandbox.client_id'
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.sandbox.secret'
                    ],
                    [
                        'title' => 'Sandbox OAuth2 Token Entry',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.sandbox.oauth2_token_url'
                    ]
                ]
            ]);
            AdminService::registerSubgroupToGroup($groupTag, 'paypalexpress', 'production', [
                'title' => 'Production API Settings',
                'items' => [
                    [
                        'title' => 'Production ClientID',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.production.client_id'
                    ],
                    [
                        'title' => 'Production Secret',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.production.secret'
                    ],
                    [
                        'title' => 'Production OAuth2 Token Entry',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.paypalexpress.production.oauth2_token_url'
                    ],
                ]
            ]);
        };
    }
}