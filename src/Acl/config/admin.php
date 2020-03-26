<?php

namespace Zento\Acl\Config;

use Zento\Acl\Providers\Facades\Acl;
use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet;
use Zento\Catalog\Model\ORM\Product;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    protected function _registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('ACL', 'mdi-warehouse');
        AdminDashboardService::registerLevel1MenuNode('ACL', 'Backend', 
            'mdi-sitemap', '/admin/acl/backend');
        AdminDashboardService::registerLevel1MenuNode('ACL', 'Front-end', 
            'mdi-shape', '/admin/acl/front-end');
    }

    /**
     * register configuration menus
     */
    protected function _registerDynamicConfigItemMenus() {}

    protected function _registerDataTableSchemas(&$data) {
        $idItem = [
            'text' => 'ID',
            'ui' => 'z-label',
            'value' => 'id',
            'filter_ui' => 'config-text-item',
            'clearable' => true
        ];
        $nameItem = [
            'text' => 'Name',
            'ui' => 'z-label',
            'value' => 'name',
            'filter_ui' => 'config-text-item',
            'clearable' => true,
        ];
        $activeItem = 
        [
            'text' => 'Active',
            'ui' => 'z-boolean-chip',
            'value' => 'active',
            'filter_ui' => 'config-options-item',
            'options' => [
                ['label' => 'Active', 'value' => 1],
                ['label' => 'Unactive', 'value' => 0]
            ],
            'clearable' => true,
        ];
        $actionItem = 
        [
            'text' => 'Actions',
            'ui' => 'z-config-actions',
            'value' => '_none_',
            'options' => [
                [
                    'label' => 'Edit',
                    'value' => 'editModel'
                ]
            ]
                ];

        $roleFunc = function($pathTag) use($idItem, $nameItem, $activeItem, $actionItem) {
            AdminConfigurationService::registerGroup($pathTag, 
            [
                'headers' => [
                    $idItem,
                    $nameItem,
                    $activeItem,
                    $actionItem
                ],
                'primary_key' => 'id',
            ]);
        };
       
        $data['frontend_role'] = $roleFunc;
        $data['administrator_role'] = $roleFunc;

        $headers = [
            $idItem,
            [
                'text' => 'First Name',
                'ui' => 'z-label',
                'value' => 'firstname',
                'filter_ui' => 'config-text-item',
                'clearable' => true,
            ],
            [
                'text' => 'Last Name',
                'ui' => 'z-label',
                'value' => 'lastname',
                'filter_ui' => 'config-text-item',
                'clearable' => true,
            ],
            [
                'text' => 'Email Address',
                'ui' => 'z-label',
                'value' => 'email',
                'filter_ui' => 'config-text-item',
                'clearable' => true,
            ],
            $activeItem,
            $actionItem
        ];

        $userFunc = function($pathTag) use ($headers) {
            AdminConfigurationService::registerGroup($pathTag, 
            [
                'headers' => $headers,
                'primary_key' => 'id',
            ]
            );
        };

        $data['administrator_user'] = $userFunc;
        $data['frontend_user'] = $userFunc;

        array_unshift($headers, [
            'text' => 'Has the role',
            'ui' => 'config-boolean-item',
            'value' => 'role_id'
        ]);
        array_pop($headers);
        $userFunc = function($pathTag) use ($headers) {
            AdminConfigurationService::registerGroup($pathTag, 
            [
                'headers' => $headers,
                'primary_key' => 'id',
            ]
            );
        };
        $data['administrator_role_user'] = $userFunc;
        $data['frontend_role_user'] = $userFunc;
    }

    protected function _registerDynamicConfigItemGroups( &$data) {
    }

    protected function _registerModelDefines(&$data) {
        $data['role'] = function($tag) {
            $items[] = [
                'text' => 'Name',
                'ui' => 'config-text-item',
                'accessor' => 'name'
            ];
            $items[] = [
                'text' => 'Description',
                'ui' => 'config-text-item',
                'accessor' => 'description'
            ];

            $items[] = [
                'text' => 'Active',
                'ui' => 'config-boolean-item',
                'accessor' => 'active'
            ];
            AdminConfigurationService::registerGroup($tag, 
            [
                'basic' =>['text' => 'Details', 'items' => $items]
            ]);
        };

        $data['user'] = function($tag) {
            $items[] = [
                'text' => 'First Name',
                'ui' => 'config-text-item',
                'accessor' => 'firstname'
            ];
            $items[] = [
                'text' => 'Last Name',
                'ui' => 'config-text-item',
                'accessor' => 'lastname'
            ];
            $items[] = [
                'text' => 'Email Address',
                'ui' => 'config-text-item',
                'accessor' => 'email'
            ];
            $items[] = [
                'text' => 'Password',
                'ui' => 'config-text-item',
                'accessor' => 'password'
            ];
            $items[] = [
                'text' => 'Active',
                'ui' => 'config-boolean-item',
                'accessor' => 'active'
            ];
            AdminConfigurationService::registerGroup($tag, 
            [
                'basic' =>['text' => 'Details', 'items' => $items]
            ]);
        };
    }
}