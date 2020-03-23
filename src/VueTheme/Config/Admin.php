<?php

namespace Zento\VueTheme\Config;

use Zento\VueTheme\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    protected function _registerDashboardMenus() {}

    protected function _registerDynamicConfigItemMenus() {
        AdminConfigurationService::registerLevel1MenuNode('Theme', 'VueTheme');
    }

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerModelDefines(&$data){}
    
    protected function _registerDynamicConfigItemGroups($groupTag, &$groups) {
        $groups['theme/vuetheme'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'settings',  [
                'title' => 'Basic Settings',
                'items' => [
                    [
                        'title' => 'Page Footer Data',
                        'ui' => 'config-json-item',
                        'schema' => [
                            'icons' => [
                                [
                                    "icon" => "config-text-item",
                                    "link" => "config-text-item"
                                ]
                            ],
                            'links' => [
                                [
                                    "title" => "config-text-item",
                                    "link" => "config-text-item"
                                ]
                            ],
                            'company' => [
                                "name"=>"config-text-item",
                                "description" => "config-text-item"
                            ],
                            "copyright" => "config-text-item"
                        ],
                        'accessor' => Consts::CONFIG_KEY_FOOTER_DATA
                    ]
                ]
            ]);
        };
    }
}
