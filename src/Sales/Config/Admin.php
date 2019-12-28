<?php

namespace Zento\Sales\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    public function registerDashboardMenus() {

    }
    public function registerConfigMenus() {
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['tables/orders'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Table Definition',
                'items' => [
                    [
                        'text' => 'Order ID',
                        'value' => 'id'
                    ],
                    [
                        'text' => 'Order Number',
                        'value' => 'order_number'
                    ],
                    [
                        'text' => 'Status',
                        'ui' => 'config-options-item',
                        'value' => 'status_id',
                        'options' => [
                            [
                                'value' => '0',
                                'label' => 'Pending'
                            ],
                        ]
                    ],
                    [
                        'text' => 'Customer',
                        'value' => 'customer.email',
                    ],
                    [
                        'text' => 'Guest Order',
                        'ui' => 'config-boolean-item',
                        'value' => 'is_guest',
                    ],
                    [
                        'text' => 'Created At',
                        'value' => 'created_at',
                    ],
                    [
                        'text' => 'Updated At',
                        'value' => 'updated_at',
                    ],
                ]
            ]);
        };
    }
}
