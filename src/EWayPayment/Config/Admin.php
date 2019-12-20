<?php

namespace Zento\EwayPayment\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['Sales/PaymentGateway'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'eWay',  [
                'title' => 'eWay Transparent',
                'items' => [
                    [
                        'title' => 'Enabled In Frontend',
                        'ui' => 'config-boolean-item',
                        'accessor' => 'paymentgateway.eway.frontend.enabled'
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'ui' => 'config-boolean-item',
                        'accessor' => 'paymentgateway.eway.admin.enabled'
                    ],
                    [
                        'title' => 'Mode',
                        'ui' => 'config-options-item',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'], 
                            ['value' => 'production', 'label' => 'Production']
                        ],
                        'accessor' => 'paymentgateway.eway.mode'
                    ],
                    [
                        'title' => 'Sandbox ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => 'paymentgateway.eway.sandbox.client_id'
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => 'paymentgateway.eway.sandbox.secret'
                    ],
                    [
                        'title' => 'Production ClientID',
                        'ui' => 'config-longtext-item',
                        'accessor' => 'paymentgateway.eway.production.client_id'
                    ],
                    [
                        'title' => 'Production Secret',
                        'ui' => 'config-longtext-item',
                        'accessor' => 'paymentgateway.eway.production.secret'
                    ]
                ]
            ]);
        };
    }
}