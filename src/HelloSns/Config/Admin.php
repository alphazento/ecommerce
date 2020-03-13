<?php

namespace Zento\HelloSns\Config;

use Zento\HelloSns\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    public function registerConfigMenus() {
        AdminConfigurationService::registerL1MenuNode('Website', 'HelloSns');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/hellosns'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'frontend',  [
                'title' => 'Front-end Panel use Hellosns',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'frontend'),
                    ],
                    [
                        'title' => 'Allow Services',
                        'ui' => 'config-multi-options-item',
                        'accessor' => sprintf(Consts::ALLOW_SERVICES, 'frontend'),
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
                        'title' => 'Response Type',
                        'ui' => 'config-options-item',
                        'accessor' => sprintf(Consts::RESPONSE_TYPE, 'frontend'),
                        'options' => [
                            ['label' => 'code', 'value'=>'code'],
                            ['label' => 'token', 'value'=>'token']
                        ]
                    ],
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
            AdminConfigurationService::registerGroup($groupTag, 'backend',  [
                'title' => 'Admin Panel use Hellosns',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => sprintf(Consts::ENABLED, 'backend'),
                    ],
                    [
                        'title' => 'Allow Services',
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

            AdminConfigurationService::registerGroup($groupTag, 'services',  [
                'title' => 'Social Media Login Services',
                'items' => [
                    [
                        'title' => 'Facebook',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::FACEBOOK_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'title' => 'Google',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GOOGLE_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'title' => 'LinkedIn',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::LINKEDIN_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'title' => 'Github',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GITHUB_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'title' => 'GitLab',
                        'ui' => 'config-json-item',
                        'accessor' => Consts::GITLAB_SERVICE,
                        'schema' => [
                            "client_id" => "config-text-item",
                            "client_secret" => "config-text-item",
                            "redirect" => "config-text-item"
                        ],
                    ],
                    [
                        'title' => 'Bitbucket',
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

        // $groups['tables/dynamicattributes']  = function($groupTag) {
        //     AdminConfigurationService::removeItemFromGroup($groupTag, 'table', 'Type');
        // };
    }
}