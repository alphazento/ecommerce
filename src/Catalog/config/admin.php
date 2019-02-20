<?php

namespace Zento\Catalog\Config;

use Zento\Backend\Providers\Facades\AdminService;

class Admin {
    public function registeConfigMenus() {
    }

    public function registerGroupIfMatchs($l0name, $l1name) {
        $key = strtolower(sprintf('%s/%s', $l0name, $l1name));
        $groups = [
            'Catalog/Category' => function($key) {
                AdminService::registerGroup($key, 'category',  [
                    'title' => 'Category Settings',
                    'groupSave' => true,
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
                AdminService::registerSubgroupToGroup($key, 'category', 'content', [
                    'title' => 'Content',
                    'items' => [
                        [
                            'title' => 'Category Image',
                            'type' => 'LongText',
                            'cpath' => 'meta_description'
                        ]
                    ]
                ]);
                AdminService::registerSubgroupToGroup($key, 'category', 'seo', [
                    'title' => 'Search Engine Optimization ',
                    'items' => [
                        [
                            'title' => 'Url Key',
                            'type' => 'LongText',
                            'cpath' => 'url_key'
                        ]
                    ]
                ]);
            },
        ];
        foreach($groups as $l0l1name => $cb) {
            if ($key === strtolower($l0l1name)) {
                call_user_func($cb, $key);
            }
        }
        return $key;
    }
}