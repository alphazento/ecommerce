<?php

namespace Zento\Backend\Config;

use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Backend\Providers\Facades\AdminDashboardService;

class Admin extends AbstractAdminConfig
{
    protected function _registerDashboardMenus()
    {
        AdminDashboardService::registerRootLevelMenuNode('Store', 'mdi-store');
        AdminDashboardService::registerLevel1MenuNode('Store', 'Configuration', 'mdi-settings', '/admin/store-configurations');
        AdminDashboardService::registerLevel1MenuNode('Store', 'Attributes', 'mdi-code-braces', '/admin/store-dynamic-attributes');
        AdminDashboardService::registerLevel1MenuNode('Store', 'Attribute Sets', 'mdi-contain', '/admin/store-dynamic-attribute-sets');
    }

    protected function _registerDynamicConfigItemMenus()
    {
        AdminConfigurationService::registerRootLevelMenuNode('Website');
        AdminConfigurationService::registerRootLevelMenuNode('Sales');
        AdminConfigurationService::registerRootLevelMenuNode('Checkout');
        AdminConfigurationService::registerRootLevelMenuNode('Third Party');
        AdminConfigurationService::registerLevel1MenuNode('Website', 'Web');
        AdminConfigurationService::registerLevel1MenuNode('Website', 'Admin');
        AdminConfigurationService::registerLevel1MenuNode('Sales', 'Payment Gateway');
        AdminConfigurationService::registerLevel1MenuNode('Sales', 'Email');
    }

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $data['website/admin'] = function ($groupTag) {
            AdminConfigurationService::registerGroup([$groupTag, 'ip_restrict'], [
                'text' => 'Allow IPs',
                'items' => [
                    [
                        'text' => 'Enabled',
                        'ui' => 'config-text-item',
                        'accessor' => 'admin.ip_restrict.eanbled',
                    ],
                    [
                        'text' => 'Admin URL',
                        'ui' => 'config-text-item',
                        'accessor' => 'admin.admin_url',
                    ],
                ],
            ]);
        };

        $data['website/web'] = function ($groupTag) {
            AdminConfigurationService::registerGroup([$groupTag, 'base'], [
                'text' => 'Basic Settings',
                'items' => [
                    [
                        'text' => 'Base URL',
                        'ui' => 'config-text-item',
                        'accessor' => 'website.web.base_url',
                    ],
                ],
            ]);

            AdminConfigurationService::registerGroup([$groupTag, 'url_rewrite'], [
                'text' => 'Allow Url Rewrite',
                'items' => [
                    [
                        'text' => 'Enabled',
                        'ui' => 'config-boolean-item',
                        'accessor' => 'website.web.url_rewrite.eanbled',
                    ],
                ],
            ]);
        };
    }

    protected function _registerDataTableSchemas(&$data)
    {
        $data['dynamic-attributes'] = function ($groupTag) {
            AdminConfigurationService::registerGroup($groupTag,
                [
                    [
                        'text' => 'Name',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item', //for edit
                        'value' => 'name',
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
                                'label' => 'integer',
                            ],
                            [
                                'value' => 'varchar',
                                'label' => 'varchar(255)',
                            ],
                            [
                                'value' => 'text',
                                'label' => 'text',
                            ],
                        ],
                    ],
                    [
                        'text' => 'Front Label',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'front_label',
                        'editable' => true,
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
                            ],
                        ],
                    ],
                    [
                        'text' => 'Front Group/Tab',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'front_group',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Admin Label',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'admin_label',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Admin Group',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'admin_group',
                        'editable' => true,
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
                                'label' => 'config-text-item',
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
                        ],
                    ],
                    [
                        'text' => 'Default Value',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'default_value',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Active',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'active',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Single',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'single',
                        'editable' => false, //only new item is editable
                    ],
                    [
                        'text' => 'Use Attribute Container',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'use_container',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Value Map',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'with_value_map',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Searchable',
                        'ui' => 'z-boolean-chip',
                        'edit_ui' => 'config-boolean-item',
                        'value' => 'searchable',
                        'editable' => true,
                    ],
                    [
                        'text' => 'Sort',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item',
                        'value' => 'sort',
                        'editable' => true,
                    ],
                ]);
        };

        $data['dynamic-attribute-sets'] = function ($groupTag) {
            AdminConfigurationService::registerGroup($groupTag,
                [
                    [
                        'text' => 'Name',
                        'ui' => 'z-label',
                        'edit_ui' => 'config-text-item', //for edit
                        'value' => 'name',
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
                ]);
        };
    }

    protected function _registerModelDefines(&$data)
    {}
}
