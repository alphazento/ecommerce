<?php

namespace Zento\Acl\Config;

use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet;
use Zento\Catalog\Model\ORM\Product;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('API Access Control', 'mdi-warehouse');
        AdminDashboardService::registerL1MenuNode('API Access Control', 'Backend', 
            'mdi-sitemap', '/admin/acl/backend');
        AdminDashboardService::registerL1MenuNode('API Access Control', 'Front-end', 
            'mdi-shape', '/admin/acl/front-end');
    }

    protected function _registerGroups($groupTag, &$groups) {}
}