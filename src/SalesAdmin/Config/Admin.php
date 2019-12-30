<?php

namespace Zento\SalesAdmin\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    public function registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('Sales', 'Sales', 'mdi-store');
        AdminDashboardService::registerL1MenuNode('Sales', 'Orders', 'Orders', 
            'mdi-settings', '/admin/sales_orders');
    }

    public function registerConfigMenus() {
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['tables/orders'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Order Table Definition',
                'items' => [
                    [
                        'text' => 'ID',
                        'ui' => 'z-label',
                        'value' => 'id'
                    ],
                    [
                        'text' => 'Order Number',
                        'ui' => 'z-label',
                        'value' => 'order_number',
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Status',
                        'ui' => 'z-options-display',
                        'value' => 'status_id',
                        'options' => $this->getOrderStatusOptions(),
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Payment',
                        'ui' => 'z-orders-payment-column',
                        'value' => 'payment',
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Customer',
                        'ui' => 'z-orders-customer-column',
                        'value' => 'customer',
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Order Detail',
                        'ui' => 'z-label',
                        'value' => 'order_detail',
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Order Items',
                        'ui' => 'z-label',
                        'value' => 'order_items',
                        'filter_ui' => 'config-text-item'
                    ],
                    [
                        'text' => 'Created At',
                        'ui' => 'z-label',
                        'value' => 'created_at',
                        'filter_ui' => 'config-date-range-item'
                    ],
                ]
            ]);
        };
    }

    protected function getOrderStatusOptions() {
        return [
            [
                'value' => 0,
                'label' => 'Pending'
            ],
            [
                'value' => 10,
                'label' => 'Completed'
            ],
            [
                'value' => 4,
                'label' => 'Cancel'
            ],
            [
                'value' => 5,
                'label' => 'Hold'
            ],
            [
                'value' => 1,
                'label' => 'Processing'
            ]
        ];
    }
}
