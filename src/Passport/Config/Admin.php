<?php

namespace Zento\Passport\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Passport\Consts;

class Admin extends AbstractAdminConfig {
    protected function _registerDashboardMenus() {}
    
    protected function _registerDynamicConfigItemMenus() {
        AdminConfigurationService::registerLevel1MenuNode('Website', 'Passport');
    }

    protected function _registerDynamicConfigItemGroups($groupTag, &$groups) {
        $groups['website/passport'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'client',  [
                'text'=> 'Default Client',
                'items' => [
                    [
                        'text'=> 'Enable Passport Guest Token',
                        'ui' => 'config-options-item',
                        'options' => [
                            [
                                'label' => 'password',
                                'value' => 'password',
                            ]
                        ],
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_GRANT_TYPE
                    ],
                    [
                        'text'=> 'Client ID',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_ID
                    ],
                    [
                        'text'=> 'Client Secret',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_SECRET
                    ],
                    [
                        'text'=> 'Scope',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_SCOPE
                    ]
                ]
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerModelDefines(&$data){}
    
}
