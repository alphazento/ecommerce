<?php

namespace Zento\HelloSns\Config;

use Zento\HelloSns\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminService;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerL1MenuNode('Website', 'HelloSns', 'HelloSns');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/hellosns'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'frontend',  [
                'title' => 'Front-end Panel use Hellosns',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'frontend'),
                    ],
                    [
                        'title' => 'Response Type',
                        'ui' => 'config-options-item',
                        'accessor' => sprintf(Consts::RESPONSE_TYPE, 'frontend'),
                        'options' => [
                            ['label' => 'code', 'value'=>'code'],
                            ['label' => 'token', 'value'=>'token']
                        ]
                    ],
                    // [
                    //     'title' => 'Allow Services',
                    //     'ui' => 'config-options-item',
                    //     'accessor' => sprintf(Consts::ALLOW_SERVICES, 'frontend'),
                    // ],
                    [
                        'title' => 'Use State Check',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::CHECK_STATE, 'frontend'),
                    ],
                    [
                        'title' => 'Can create account if not same user exists',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ALLOW_CREATE_ACCOUNT, 'frontend'),
                    ],
                ]
            ]);
            AdminService::registerGroup($groupTag, 'backend',  [
                'title' => 'Admin Panel use Hellosns',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'backend'),
                    ],
                    [
                        'title' => 'Response Type',
                        'ui' => 'config-options-item',
                        'accessor' => sprintf(Consts::RESPONSE_TYPE, 'backend'),
                        'options' => [
                            ['label' => 'code', 'value'=>'code'],
                            ['label' => 'token', 'value'=>'token']
                        ]
                    ],
                    // [
                    //     'title' => 'Allow Services',
                    //     'ui' => 'config-options-item',
                    //     'accessor' => sprintf(Consts::ALLOW_SERVICES, 'backend'),
                    // ],
                    [
                        'title' => 'Use State Check',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::CHECK_STATE, 'backend'),
                    ],
                    [
                        'title' => 'Can create account if user not exists',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ALLOW_CREATE_ACCOUNT, 'backend'),
                    ],
                ]
            ]);
        };
    }
}