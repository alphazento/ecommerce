<?php

namespace Zento\BladeTheme\Config;

use Zento\BladeTheme\Consts;
use Zento\Kernel\Consts as KernelConsts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminService;
use Zento\Kernel\Facades\ThemeManager;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Theme', 'Theme');
        AdminService::registerL1MenuNode('Theme', 'Themes', 'Themes');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['theme/themes'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'basic',  [
                'title' => 'Basic Settings',
                'items' => [
                    [
                        'title' => 'Enable Passport Guest Token(so can use api resources)',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::WORK_WITH_PASSPORT_GUEST_TOKEN
                    ],
                    [
                        'title' => 'Desktop Theme',
                        'ui' => 'config-options-item',
                        'options' => $this->themes(),
                        'accessor' => KernelConsts::CACHE_KEY_DESKTOP_THEME
                    ],
                    [
                        'title' => 'Mobile Theme',
                        'ui' => 'config-options-item',
                        'options' => $this->themes(),
                        'accessor' => KernelConsts::CACHE_KEY_MOBILE_THEME
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
