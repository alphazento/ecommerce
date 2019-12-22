<?php

namespace Zento\VueTheme\Config;

use Zento\VueTheme\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminService;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerL1MenuNode('Theme', 'VueTheme', 'VueTheme');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['theme/vuetheme'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'settings',  [
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
                        'accessor' => Consts::FOOTER_CONFIG_KEY
                    ]
                ]
            ]);
        };
    }
}
