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
                        'title' => 'Assets Location',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::ASSETS_LOCATION
                    ],
                    [
                        'title' => 'Logo',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::LOGO
                    ]
                ]
            ]);
        };
    }

    protected $themeOptions;
    protected function themes() {
        // 'options' => 
        if (!$this->themeOptions) {
            $themes = ThemeManager::availableThemes();
            
            $this->themeOptions = array_map(function($theme) {
                return ['label' => $theme, 'value' => $theme];
            }, $themes);
        }
        return $this->themeOptions;
    }
}
