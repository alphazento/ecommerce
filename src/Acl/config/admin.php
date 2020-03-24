<?php

namespace Zento\Acl\Config;

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
        $func = function($pathTag) {
            AdminConfigurationService::registerGroup($pathTag, 
            [
                'headers' => [
                    [
                        'text' => 'ID',
                        'ui' => 'z-label',
                        'value' => 'id',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true
                    ],
                    [
                        'text' => 'Name',
                        'ui' => 'z-label',
                        'value' => 'name',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true,
                    ],
                    [
                        'text' => 'Description',
                        'ui' => 'z-label',
                        'value' => 'description',
                        'filter_ui' => 'config-text-item',
                        'clearable' => true,
                    ],
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
                    ]
                ],
                'primary_key' => 'id',
            ]);
        };
       
        $data['frontend_role'] = $func;
        $data['administrator_role'] = $func;
    }

    protected function _registerDynamicConfigItemGroups( &$data) {
    }

    protected function _registerModelDefines(&$data){}
}