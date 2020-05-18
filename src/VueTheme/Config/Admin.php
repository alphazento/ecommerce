<?php

namespace Zento\VueTheme\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\VueTheme\Consts;

class Admin extends AbstractAdminConfig
{
    protected function _registerDashboardMenus()
    {}

    protected function _registerDynamicConfigItemMenus()
    {
        AdminConfigurationService::registerLevel1MenuNode('Theme', 'VueTheme');
    }

    protected function _registerDataTableSchemas(&$data)
    {}

    protected function _registerModelDefines(&$data)
    {}

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $data['theme/vuetheme'] = function ($groupTag) {
            AdminConfigurationService::registerGroup([$groupTag, 'settings'], [
                'text' => 'Basic Settings',
                'items' => [
                    [
                        'text' => 'Page Footer Data',
                        'ui' => 'config-json-item',
                        'schema' => [
                            'icons' => [
                                [
                                    "icon" => "config-text-item",
                                    "link" => "config-text-item",
                                ],
                            ],
                            'links' => [
                                [
                                    "title" => "config-text-item",
                                    "link" => "config-text-item",
                                ],
                            ],
                            'company' => [
                                "name" => "config-text-item",
                                "description" => "config-text-item",
                            ],
                            "copyright" => "config-text-item",
                        ],
                        'accessor' => Consts::CONFIG_KEY_FOOTER_DATA,
                    ],

                    [
                        'text' => 'Home Page Carousel',
                        'ui' => 'config-json-item',
                        'schema' => [
                            'images' => [
                                [
                                    'img' => 'config-image-uploader-item::{"folder": "/", "accept": "image/png, image/jpeg, image/jpg", "fileType":"png,jpeg,jpg,bmp"}',
                                    "title" => "config-text-item",
                                ],
                            ],
                        ],
                        'accessor' => 'vuetheme.hompage.carousel',
                    ],

                    [
                        'text' => 'Home Page Collection Gallery',
                        'ui' => 'config-json-item',
                        'schema' => [
                            'cards' => [
                                [
                                    'img' => 'config-image-uploader-item::{"folder": "/", "accept": "image/png, image/jpeg, image/jpg", "fileType":"png,jpeg,jpg,bmp"}',
                                    'title' => 'config-text-item',
                                    'flex' => "config-text-item",
                                    'url' => "config-text-item",
                                ],
                            ],
                        ],
                        'accessor' => 'vuetheme.hompage.collection.gallery',
                    ],
                ],
            ]);
        };
    }
}
