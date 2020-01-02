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
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Status',
                        'ui' => 'z-orders-status-action-column',
                        'value' => 'status_id',
                        'options' => $this->getOrderStatusOptions(),
                        'filter_ui' => 'config-options-item',
                        'filter_data_type' => 'number',
                    ],
                    [
                        'text' => 'Payment',
                        'ui' => 'z-orders-payment-column',
                        'value' => 'payment',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Customer',
                        'ui' => 'z-orders-customer-column',
                        'value' => 'customer',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Order Detail',
                        'ui' => 'z-label',
                        'value' => 'order_detail',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Order Items',
                        'ui' => 'z-label',
                        'value' => 'order_items',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Created At',
                        'ui' => 'z-label',
                        'value' => 'created_at',
                        'filter_ui' => 'config-date-range-item',
                    ],
                ]
            ]);
        };
    }

    protected function getOrderStatusOptions() {
        return [
            [
                'value' => '',
                'label' => 'Not Set'
            ],
            [
                'value' => 0,
                'label' => 'Pending',
                'color' => '#E0BFBE'
            ],
            [
                'value' => 10,
                'label' => 'Completed',
                'next_cadidates' => [1,4,5],
                'color' => 'success'
            ],
            [
                'value' => 4,
                'label' => 'Cancel',
                'next_cadidates' => [1, 5, 10],
                'color' => 'error'
            ],
            [
                'value' => 5,
                'label' => 'Hold',
                'color' => 'pink'

            ],
            [
                'value' => 1,
                'label' => 'Processing',
                'next_cadidates' => [4, 5, 10],
                'color' => 'primary'
            ]
        ];
    }
}
