<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    public function registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('Store', 'mdi-store');
        AdminDashboardService::registerL1MenuNode('Store', 'Configuration', 'mdi-settings', '/admin/store-configurations');
        AdminDashboardService::registerL1MenuNode('Store', 'Attribute Set', 'mdi-contain', '/admin/store-dynamic-attribute-sets');
        AdminDashboardService::registerL1MenuNode('Store', 'Dynamic Attributes', 'mdi-code-braces', '/admin/store-dynamic-attributes');
    }

    public function registerConfigMenus() {
        AdminConfigurationService::registerRootLevelMenuNode('Website');
        AdminConfigurationService::registerRootLevelMenuNode('Sales');
        AdminConfigurationService::registerRootLevelMenuNode('Checkout');
        AdminConfigurationService::registerRootLevelMenuNode('Third Party');
        AdminConfigurationService::registerL1MenuNode('Website', 'Web');
        AdminConfigurationService::registerL1MenuNode('Website', 'Admin');
        AdminConfigurationService::registerL1MenuNode('Sales', 'Payment Gateway');
        AdminConfigurationService::registerL1MenuNode('Sales', 'Email');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/admin'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'ip_restrict',  [
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
            AdminConfigurationService::registerGroup($groupTag, 'base',  [
                'title' => 'Basic Settings',
                'items' => [
                    [
                        'title' => 'Base URL',
                        'ui' => 'config-text-item',
                        'accessor' => 'website.web.base_url'
                    ],
                ]
            ]);

            AdminConfigurationService::registerGroup($groupTag, 'url_rewrite',  [
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

        $groups['tables/dynamic-attributes'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Model Dynamic Attributes Editor Template Definition',
                'items' => [
                    [
                        'text' => 'Name',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',  //for edit
                        'value' => 'name'
                    ],
                    [
                        'text' => 'Type',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-options-item',
                        'value' => 'attribute_type',
                        'editable' => false,
                        'options' => [
                            [
                                'value' => 'integer',
                                'label' => 'integer'
                            ],
                            [
                                'value' => 'varchar',
                                'label' => 'varchar(255)'
                            ],
                            [
                                'value' => 'text',
                                'label' => 'text'
                            ],
                        ]
                    ],
                    [
                        'text' => 'Front Component',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-options-item',
                        'value' => 'front_component',
                        'editable' => true,
                        'options' => [
                            [
                                'label' => 'text/html/vue',
                                'value' => 'z-html-block',
                            ],
                            [
                                'label' => 'markdown',
                                'value' => 'z-markdown',
                            ]
                        ]
                    ],
                    [
                        'text' => 'Front Group/Tab',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'front_group',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Label',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'admin_label',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Group',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'admin_group',
                        'editable' => true
                    ],
                    [
                        'text' => 'Admin Component',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-options-item',
                        'value' => 'admin_component',
                        'editable' => true,
                        'options' => [
                            [
                                'value' => 'config-text-item',
                                'label' => 'config-text-item'
                            ],
                            [
                                'value' => 'config-longtext-item',
                                'label' => 'config-longtext-item',
                            ],
                            [
                                'value' => 'config-options-item',
                                'label' => 'config-options-item',
                            ],
                            [
                                'value' => 'config-multi-options-item',
                                'label' => 'config-multi-options-item',
                            ],
                            [
                                'value' => 'config-boolean-item',
                                'label' => 'config-boolean-item',
                            ],
                            [
                                'value' => 'config-date-item',
                                'label' => 'config-date-item',
                            ],
                            [
                                'value' => 'config-image-uploader-item',
                                'label' => 'config-image-uploader-item',
                            ],
                            [
                                'value' => 'z-vue-editor',
                                'label' => 'z-vue-editor',
                            ],
                            [
                                'value' => 'z-markdown-editor',
                                'label' => 'z-markdown-editor',
                            ],
                        ]
                    ],
                    [
                        'text' => 'Default Value',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'default_value',
                        'editable' => true
                    ],
                    [
                        'text' => 'Active',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'active',
                        'editable' => true
                    ],
                    [
                        'text' => 'Single',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'single',
                        'editable' => false   //only new item is editable
                    ],
                    [
                        'text' => 'Swatch',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'swatch',
                        'editable' => true
                    ],
                    [
                        'text' => 'Value Map',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'with_value_map',
                        'editable' => true
                    ],
                    [
                        'text' => 'Searchable',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'searchable',
                        'editable' => true
                    ],
                    [
                        'text' => 'Sort',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'sort',
                        'editable' => true
                    ],
                ]
            ]);
        };

        $groups['tables/dynamic-attribute-sets'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Attribute Set Editor Template Definition',
                'items' => [
                    [
                        'text' => 'Name',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',  //for edit
                        'value' => 'name'
                    ],
                    [
                        'text' => 'Description',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-longtext-item',
                        'value' => 'description',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Active',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'active',
                        'editable' => true,
                    ],
                ]
            ]);
        };
    }
}
