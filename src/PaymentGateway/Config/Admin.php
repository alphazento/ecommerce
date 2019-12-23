<?php

namespace Zento\PaymentGateway\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
    }
    public function _registerGroups($groupTag, &$groups) {
    }
}