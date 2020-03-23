<?php

namespace Zento\PaymentGateway\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    protected function _registerDashboardMenus() {}

    protected function _registerDynamicConfigItemMenus() {
        AdminConfigurationService::registerRootLevelMenuNode('Sales');
        AdminConfigurationService::registerLevel1MenuNode('Sales', 'Payment Gateway');
    }

    protected function _registerDynamicConfigItemGroups($groupTag, &$groups) {}

    protected function _registerDataTableSchemas($dataTableName, &$groups) {}

    protected function _registerModelDefines($dataTableName, &$groups){}
    
}