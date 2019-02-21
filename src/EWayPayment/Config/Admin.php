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
                        'type' => 'Switch',
                        'cpath' => 'paymentgateway.eway.frontend.enabled'
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'type' => 'Switch',
                        'cpath' => 'paymentgateway.eway.admin.enabled'
                    ],
                    [
                        'title' => 'Mode',
                        'type' => 'SelectBox',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'], 
                            ['value' => 'production', 'label' => 'Production']
                        ],
                        'cpath' => 'paymentgateway.eway.mode'
                    ],
                    [
                        'title' => 'Sandbox ClientID',
                        'type' => 'LongText',
                        'cpath' => 'paymentgateway.eway.sandbox.client_id'
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'type' => 'LongText',
                        'cpath' => 'paymentgateway.eway.sandbox.secret'
                    ],
                    [
                        'title' => 'Production ClientID',
                        'type' => 'LongText',
                        'cpath' => 'paymentgateway.eway.production.client_id'
                    ],
                    [
                        'title' => 'Production Secret',
                        'type' => 'LongText',
                        'cpath' => 'paymentgateway.eway.production.secret'
                    ]
                ]
            ]);
        };
    }
}