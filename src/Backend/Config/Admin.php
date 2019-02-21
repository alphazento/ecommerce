<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Website', 'Website');
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerRootLevelMenuNode('Theme', 'Theme');
        AdminService::registerRootLevelMenuNode('Checkout', 'Checkout');
        AdminService::registerL1MenuNode('Website', 'Web', 'Web');
        AdminService::registerL1MenuNode('Website', 'Admin', 'Admin');
        AdminService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
        AdminService::registerL1MenuNode('Sales', 'Email', 'Email');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/admin'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'ip_restrict',  [
                'title' => 'Allow IPs',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'type' => 'Switch',
                        'cpath' => 'admin.ip_restrict.eanbled'
                    ],
                    [
                        'title' => 'Admin URL',
                        'type' => 'Text',
                        'cpath' => 'admin.admin_url'
                    ],
                ]
            ]);
        };

        $groups['website/web'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'base',  [
                'title' => 'Basic Settings',
                'items' => [
                    [
                        'title' => 'Base URL',
                        'type' => 'Text',
                        'cpath' => 'website.web.base_url'
                    ],
                    [
                        'title' => 'Test Item',
                        'type' => 'Switch',
                        'cpath' => 'website.web.test.eanbled'
                    ],
                ]
            ]);

            AdminService::registerGroup($groupTag, 'url_rewrite',  [
                'title' => 'Allow Url Rewrite',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'type' => 'Switch',
                        'cpath' => 'website.web.url_rewrite.eanbled'
                    ]
                ]
            ]);
        };
    }
}
