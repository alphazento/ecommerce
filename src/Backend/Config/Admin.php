<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin {
    public function registeConfigMenus() {
        AdminService::registerRootLevelMenuNode('Website', 'Website');
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerRootLevelMenuNode('Theme', 'Theme');
        AdminService::registerRootLevelMenuNode('Checkout', 'Checkout');
        AdminService::registerL1MenuNode('Website', 'Web', 'Web');
        AdminService::registerL1MenuNode('Website', 'Admin', 'Admin');
        AdminService::registerL1MenuNode('Sales', 'PaymentGateway', 'Payment Gateway');
        AdminService::registerL1MenuNode('Sales', 'Email', 'Email');
    }

    public function registerGroupIfMatchs($l0name, $l1name) {
        $key = strtolower(sprintf('%s/%s', $l0name, $l1name));
        $groups = [
            'website/admin' => function($key) {
                AdminService::registerGroup($key, 'ip_restrict',  [
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

               
            },

            'website/web' => function($key) {
                AdminService::registerGroup($key, 'base',  [
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

                AdminService::registerGroup($key, 'url_rewrite',  [
                    'title' => 'Allow Url Rewrite',
                    'items' => [
                        [
                            'title' => 'Enabled',
                            'type' => 'Switch',
                            'cpath' => 'website.web.url_rewrite.eanbled'
                        ]
                    ]
                ]);
            }
        ];
        foreach($groups as $l0l1name => $cb) {
            if ($key === strtolower($l0l1name)) {
                call_user_func($cb, $key);
            }
        }
        return $key;
    }
}