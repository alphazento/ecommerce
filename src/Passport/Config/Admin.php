<?php

namespace Zento\Passport\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Passport\Consts;

class Admin extends AbstractAdminConfig {
    public function registerConfigMenus() {
        AdminConfigurationService::registerL1MenuNode('Website', 'Passport');
    }

    public function _registerGroups($groupTag, &$groups) {
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
}
