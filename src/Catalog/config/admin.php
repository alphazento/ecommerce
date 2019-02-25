<?php

namespace Zento\Catalog\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerMenus() {
    }

    protected function _registerGroups($groupTag, &$groups) {
        $groups['catalog/category'] = function($groupTag) {
            AdminService::registerGroup($groupTag, 'category',  [
                'title' => 'Category Settings',
                'items' => [
                    [
                        'title' => 'Enable Category',
                        'type' => 'Switch',
                        'cpath' => 'is_active'
                    ],
                    [
                        'title' => 'Include in Menu',
                        'type' => 'Switch',
                        'cpath' => 'include_in_menu'
                    ],
                    [
                        'title' => 'Category Name',
                        'type' => 'Text',
                        'cpath' => 'name'
                    ]
                ]
            ]);
            AdminService::registerSubgroupToGroup($groupTag, 'category', 'content', [
                'title' => 'Content',
                'items' => [
                    [
                        'title' => 'Category Image',
                        'type' => 'LongText',
                        'cpath' => 'meta_description'
                    ]
                ]
            ]);
            AdminService::registerSubgroupToGroup($groupTag, 'category', 'seo', [
                'title' => 'Search Engine Optimization ',
                'items' => [
                    [
                        'title' => 'Url Key',
                        'type' => 'LongText',
                        'cpath' => 'url_key'
                    ]
                ]
            ]);
        };
    }
}