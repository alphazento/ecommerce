<?php

namespace Zento\StoreFront\Config;

use Zento\StoreFront\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminService;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerL1MenuNode('Website', 'StoreFront', 'StoreFront');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/storefront'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'settings',  [
                'title' => 'Basic Settings',
                'items' => [
                    [
                        'title' => 'Logo',
                        'ui' => 'config-image-uploader-item',
                        'accessor' => Consts::LOGO
                    ],
                    [
                        'title' => 'Currency',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CURRENCY
                    ],
                    [
                        'title' => 'Assets Location',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::ASSETS_LOCATION
                    ],
                ]
            ]);
        };
    }
}
