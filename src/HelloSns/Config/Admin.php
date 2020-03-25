<?php

namespace Zento\HelloSns\Config;

use Zento\HelloSns\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    protected function _registerDashboardMenus() {}

    protected function _registerDynamicConfigItemMenus() {
        AdminConfigurationService::registerLevel1MenuNode('Website', 'HelloSns');
    }

    protected function _registerDynamicConfigItemGroups(&$data) {
        $data['website/hellosns'] = function($groupTag) {
            AdminConfigurationService::registerGroup([$groupTag, 'front-end'],  [
                'text' => 'Front-end Panel use Hellosns',
                'items' => [
                    [
                        'text' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'front-end'),
                    ],
                    [
                        'text' => 'Allow Services',
                        'ui' => 'config-multi-options-item',
                        'accessor' => sprintf(Consts::ALLOW_SERVICES, 'front-end'),
                        'options' => [
                            ['label' => 'Facebook', 'value'=>'facebook'],
                            ['label' => 'Google', 'value'=>'google'],
                            ['label' => 'LinkedIn', 'value'=>'linkedin'],
                            ['label' => 'Twitter', 'value'=>'twitter'],
                            ['label' => 'Github', 'value'=>'github'],
                            ['label' => 'Gitlab', 'value'=>'gitlab'],
                            ['label' => 'Bitbucket', 'value'=>'bitbucket'],
                        ]
                    ],
                    [
                        'text' => 'Response Type',
                        'ui' => 'config-options-item',
                        'accessor' => sprintf(Consts::RESPONSE_TYPE, 'front-end'),
                        'options' => [
                            ['label' => 'code', 'value'=>'code'],
                            ['label' => 'token', 'value'=>'token']
                        ]
                    ],
                    [
                        'text' => 'Use State Check',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::CHECK_STATE, 'front-end'),
                    ],
                    [
                        'text' => 'Can create account if not same user exists',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ALLOW_CREATE_ACCOUNT, 'front-end'),
                    ],
                ]
            ]);
            AdminConfigurationService::registerGroup([$groupTag, 'backend'],  [
                'text' => 'Admin Panel use Hellosns',
                'items' => [
                    [
                        'text' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'backend'),
                    ],
                    [
                        'text' => 'Allow Services',
                        'ui' => 'config-multi-options-item',
                        'accessor' => sprintf(Consts::ALLOW_SERVICES, 'backend'),
                        'options' => [
                            ['label' => 'Facebook', 'value'=>'facebook'],
                            ['label' => 'Google', 'value'=>'google'],
                            ['label' => 'LinkedIn', 'value'=>'linkedin'],
                            ['label' => 'Twitter', 'value'=>'twitter'],
                            ['label' => 'Github', 'value'=>'github'],
                            ['label' => 'Gitlab', 'value'=>'gitlab'],
                            ['label' => 'Bitbucket', 'value'=>'bitbucket'],
                        ]
                    ],
                    [
                        'text' => 'Response Type',
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
                        'text' => 'Use State Check',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::CHECK_STATE, 'backend'),
                    ],
                    [
                        'text' => 'Can create account if user not exists',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ALLOW_CREATE_ACCOUNT, 'backend'),
                    ],
                ]
            ]);

            AdminConfigurationService::registerGroup([$groupTag, 'services'],  [
                'text' => 'Social Media Login Services',
                'items' => [
                    [
                        'text' => 'Facebook',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::FACEBOOK_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'text' => 'Google',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GOOGLE_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'text' => 'LinkedIn',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::LINKEDIN_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'text' => 'Github',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GITHUB_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'text' => 'GitLab',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GITLAB_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'text' => 'Bitbucket',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::BITBUCKET_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                ]
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerModelDefines(&$data){}
    
}