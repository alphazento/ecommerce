<?php

namespace Zento\BladeTheme\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminService;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Theme', 'Theme');
    }

    public function _registerGroups($groupTag, &$groups) {
        
    }
}
