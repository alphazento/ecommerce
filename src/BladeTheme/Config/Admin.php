<?php

namespace Zento\BladeTheme\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\BladeTheme\Consts;
use Zento\Kernel\Consts as KernelConsts;
use Zento\Kernel\Facades\ThemeManager;

class Admin extends AbstractAdminConfig
{
    protected function _registerDashboardMenus()
    {}

    protected function _registerDynamicConfigItemMenus()
    {
        AdminConfigurationService::registerRootLevelMenuNode('Theme');
        AdminConfigurationService::registerLevel1MenuNode('Theme', 'All Themes');
    }

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $data['theme/themes'] = function ($key) {
            AdminConfigurationService::registerGroup([$key, 'basic'], [
                'text' => 'Basic Settings',
                'items' => [
                    [
                        'text' => 'Enable Passport Guest Token(so can use api resources)',
                        'ui' => 'config-boolean-item',
                        'accessor' => Consts::WORK_WITH_PASSPORT_GUEST_TOKEN,
                    ],
                    [
                        'text' => 'Desktop Theme',
                        'ui' => 'config-options-item',
                        'options' => $this->themes(),
                        'accessor' => KernelConsts::CACHE_KEY_DESKTOP_THEME,
                    ],
                    [
                        'text' => 'Mobile Theme',
                        'ui' => 'config-options-item',
                        'options' => $this->themes(),
                        'accessor' => KernelConsts::CACHE_KEY_MOBILE_THEME,
                    ],
                ],
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data)
    {}

    protected function _registerModelDefines(&$data)
    {}

    protected $themeOptions;
    protected function themes()
    {
        // 'options' =>
        if (!$this->themeOptions) {
            $themes = ThemeManager::availableThemes();

            $this->themeOptions = array_map(function ($theme) {
                return ['label' => $theme, 'value' => $theme];
            }, $themes);
        }
        return $this->themeOptions;
    }
}
