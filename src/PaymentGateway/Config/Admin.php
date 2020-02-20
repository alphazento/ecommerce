<?php

namespace Zento\PaymentGateway\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerConfigMenus() {
        AdminConfigurationService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminConfigurationService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
    }
    public function _registerGroups($groupTag, &$groups) {

    }
}