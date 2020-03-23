<?php

namespace Zento\Acl\Config;

use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet;
use Zento\Catalog\Model\ORM\Product;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    protected function _registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('API Access Control', 'mdi-warehouse');
        AdminDashboardService::registerLevel1MenuNode('API Access Control', 'Backend', 
            'mdi-sitemap', '/admin/acl/backend');
        AdminDashboardService::registerLevel1MenuNode('API Access Control', 'Front-end', 
            'mdi-shape', '/admin/acl/front-end');
    }

    /**
     * register configuration menus
     */
    protected function _registerDynamicConfigItemMenus() {}

    protected function _registerDataTableSchemas($groupTag, &$groups) {
        $func = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'text' => 'Front-end/Backend role data table schema',
                'items' => [
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
                ]
            ]);
        };
       
        $groups['data-table-schema/administrator_Role'] = $func;
        $groups['data-table-schema/frontend_Role'] = $func;
    }

    protected function _registerDynamicConfigItemGroups($groupTag, &$groups) {
    }

    protected function _registerModelDefines($dataTableName, &$groups){}
}