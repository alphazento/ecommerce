<?php

namespace Zento\PaymentGateway\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    protected function _registerDashboardMenus() {}

    protected function _registerDynamicConfigItemMenus() {
        AdminConfigurationService::registerRootLevelMenuNode('Sales');
        AdminConfigurationService::registerLevel1MenuNode('Sales', 'Payment Gateway');
    }

    protected function _registerDynamicConfigItemGroups( &$data) {}

    protected function _registerDataTableSchemas(&$data) {}

    protected function _registerModelDefines(&$data){}
    
}