<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

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
                        'accessor' => 'admin.ip_restrict.eanbled'
                    ],
                    [
                        'title' => 'Admin URL',
                        'type' => 'Text',
                        'accessor' => 'admin.admin_url'
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
                        'accessor' => 'website.web.base_url'
                    ],
                    [
                        'title' => 'Test Item',
                        'type' => 'Switch',
                        'accessor' => 'website.web.test.eanbled'
                    ],
                ]
            ]);

            AdminService::registerGroup($groupTag, 'url_rewrite',  [
                'title' => 'Allow Url Rewrite',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'type' => 'Switch',
                        'accessor' => 'website.web.url_rewrite.eanbled'
                    ]
                ]
            ]);
        };

        $groups['tables/dynamicattributes'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'table',  [
                'title' => 'Table Definition',
                'items' => [
                    [
                        'title' => 'Name',
                        'type' => 'Text',
                        'accessor' => 'attribute_name'
                    ],
                    [
                        'title' => 'Type',
                        'type' => 'SelectBox',
                        'accessor' => 'attribute_type',
                        'editable' => true,
                        'options' => [
                            [
                                'value' => 'integer',
                                'label' => 'Int'
                            ],
                            [
                                'value' => 'varchar',
                                'label' => 'varchar'
                            ],
                        ]
                    ],
                    [
                        'title' => 'Front Label',
                        'type' => 'Text',
                        'accessor' => 'label',
                        'editable' => true
                    ],
                    [
                        'title' => 'Admin Label',
                        'type' => 'Text',
                        'accessor' => 'admin_label',
                        'editable' => true
                    ],
                    [
                        'title' => 'Admin Group',
                        'type' => 'Text',
                        'accessor' => 'admin_group',
                        'editable' => true
                    ],
                    [
                        'title' => 'Admin Component',
                        'type' => 'SelectBox',
                        'accessor' => 'admin_component',
                        'editable' => true,
                        'options' => [
                            [
                                'value' => 'Text',
                                'label' => 'Text'
                            ],
                            [
                                'value' => 'LongText',
                                'label' => 'LongText'
                            ],
                            [
                                'value' => 'SelectBox',
                                'label' => 'SelectBox'
                            ],
                            [
                                'value' => 'Switch',
                                'label' => 'Switch'
                            ],
                            [
                                'value' => 'Image',
                                'label' => 'Image'
                            ],
                        ]
                    ],
                    [
                        'title' => 'Default Value',
                        'type' => 'Text',
                        'accessor' => 'default_value',
                        'editable' => true
                    ],
                    [
                        'title' => 'Enabled',
                        'type' => 'Switch',
                        'accessor' => 'enabled',
                        'editable' => true
                    ],
                    [
                        'title' => 'Single',
                        'accessor' => 'single',
                        'type' => 'Switch',
                        'editable' => true
                    ],
                    [
                        'title' => 'Swatch',
                        'accessor' => 'swatch_type',
                        'type' => 'Switch',
                        'editable' => true
                    ],
                    [
                        'title' => 'Value Map',
                        'accessor' => 'with_value_map',
                        'type' => 'Switch',
                        'editable' => true
                    ],
                    [
                        'title' => 'Is Search Layer',
                        'accessor' => 'is_search_layer',
                        'type' => 'Switch',
                        'editable' => true
                    ],
                    [
                        'title' => 'Search Layer Sort',
                        'accessor' => 'search_layer_sort',
                        'type' => 'Text',
                        'editable' => true
                    ],
                ]
            ]);
        };
    }
}
