<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class Admin extends AbstractAdminConfig {
    public function registerMenus() {
        AdminService::registerRootLevelMenuNode('Website', 'Website');
        AdminService::registerRootLevelMenuNode('Sales', 'Sales');
        AdminService::registerRootLevelMenuNode('Checkout', 'Checkout');
        AdminService::registerRootLevelMenuNode('ThirdParty', 'Third Party');
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
                        'ui' => 'config-text-item',
                        'accessor' => 'admin.ip_restrict.eanbled'
                    ],
                    [
                        'title' => 'Admin URL',
                        'ui' => 'config-text-item',
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
                        'ui' => 'config-text-item',
                        'accessor' => 'website.web.base_url'
                    ],
                    [
                        'title' => 'Test Item',
                        'ui' => 'config-boolean-item',
                        'accessor' => 'website.web.test.eanbled'
                    ],
                ]
            ]);

            AdminService::registerGroup($groupTag, 'url_rewrite',  [
                'title' => 'Allow Url Rewrite',
                'items' => [
                    [
                        'title' => 'Enabled',
                        'ui' => 'config-boolean-item',
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
                        'text' => 'Name',
                        'ui' => 'config-text-item',
                        'value' => 'attribute_name'
                    ],
                    [
                        'text' => 'Type',
                        'ui' => 'config-options-item',
                        'value' => 'attribute_type',
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
                        'text' => 'Front Label',
                        'ui' => 'config-text-item',
                        'value' => 'label',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Label',
                        'ui' => 'config-text-item',
                        'value' => 'admin_label',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Group',
                        'ui' => 'config-text-item',
                        'value' => 'admin_group',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Component',
                        'ui' => 'config-options-item',
                        'value' => 'admin_component',
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
                                'value' => 'MultiSelectBox',
                                'label' => 'MultiSelectBox'
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
                        'text' => 'Default Value',
                        'ui' => 'config-text-item',
                        'value' => 'default_value',
                        'editable' => true
                    ],
                    [
                        'text' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'value' => 'enabled',
                        'editable' => true
                    ],
                    [
                        'text' => 'Single',
                        'value' => 'single',
                        'ui' => 'config-boolean-item',
                        'editable' => true
                    ],
                    [
                        'text' => 'Swatch',
                        'value' => 'swatch_type',
                        'ui' => 'config-boolean-item',
                        'editable' => true
                    ],
                    [
                        'text' => 'Value Map',
                        'value' => 'with_value_map',
                        'ui' => 'config-boolean-item',
                        'editable' => true
                    ],
                    [
                        'text' => 'Is Search Layer',
                        'value' => 'is_search_layer',
                        'ui' => 'config-boolean-item',
                        'editable' => true
                    ],
                    [
                        'text' => 'Search Layer Sort',
                        'value' => 'search_layer_sort',
                        'ui' => 'config-text-item',
                        'editable' => true
                    ],
                ]
            ]);
        };
    }
}
