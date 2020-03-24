<?php

namespace Zento\SalesAdmin\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    protected function _registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('Sales', 'mdi-store');
        AdminDashboardService::registerLevel1MenuNode('Sales', 'Orders', 
            'mdi-file-table-box-multiple', '/admin/sales_orders');
    }
    
    protected function _registerDynamicConfigItemMenus() {}

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerDynamicConfigItemGroups( &$data) {
        $groups['data-table-schema/orders'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Order Table Definition',
                'items' => [
                    'headers' => [
                        [
                            'text' => 'ID/Order Number',
                            'ui' => 'z-orders-number-and-log-column',
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
                            'clearable' => true,
                            'sortable' => false
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
                            'ui' => 'z-orders-details-column',
                            'value' => 'order_detail',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                            'sortable' => false
                        ],
                        [
                            'text' => 'Shipment',
                            'ui' => 'z-orders-shipment-details',
                            'value' => 'order_items',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                            'sortable' => false
                        ],
                        [
                            'text' => 'Purchase Date',
                            'ui' => 'z-label',
                            'value' => 'created_at',
                            'filter_ui' => 'config-date-range-item',
                        ],
                    ],
                    'primary_key' => 'id',
                ]
            ]);
        };
    }

    protected function _registerModelDefines(&$data){}
    
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
