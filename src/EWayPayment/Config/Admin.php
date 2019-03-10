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
                        'accessor' => 'paymentgateway.eway.frontend.enabled'
                    ],
                    [
                        'title' => 'Enabled In Admin Panel',
                        'type' => 'Switch',
                        'accessor' => 'paymentgateway.eway.admin.enabled'
                    ],
                    [
                        'title' => 'Mode',
                        'type' => 'SelectBox',
                        'options' => [
                            ['value' => 'sandbox', 'label' => 'Sandbox'], 
                            ['value' => 'production', 'label' => 'Production']
                        ],
                        'accessor' => 'paymentgateway.eway.mode'
                    ],
                    [
                        'title' => 'Sandbox ClientID',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.eway.sandbox.client_id'
                    ],
                    [
                        'title' => 'Sandbox Secret',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.eway.sandbox.secret'
                    ],
                    [
                        'title' => 'Production ClientID',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.eway.production.client_id'
                    ],
                    [
                        'title' => 'Production Secret',
                        'type' => 'LongText',
                        'accessor' => 'paymentgateway.eway.production.secret'
                    ]
                ]
            ]);
        };
    }
}