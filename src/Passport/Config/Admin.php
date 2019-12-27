<?php

namespace Zento\Passport\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Passport\Consts;

class Admin extends AbstractAdminConfig {
    public function registerDashboardMenus() {

    }
    public function registerConfigMenus() {
        AdminConfigurationService::registerL1MenuNode('Website', 'Passport', 'Passport');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/passport'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'client',  [
                'title' => 'Default Client',
                'items' => [
                    [
                        'title' => 'Enable Passport Guest Token',
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
                        'title' => 'Client ID',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_ID
                    ],
                    [
                        'title' => 'Client Secret',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_SECRET
                    ],
                    [
                        'title' => 'Scope',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT_SCOPE
                    ]
                ]
            ]);
        };
    }
}
