<?php

namespace Zento\Catalog\Config;

use Zento\Backend\Providers\Facades\AdminService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerMenus() {
    }

    protected function _registerGroups($groupTag, &$groups) {
        $groups['catalog/category'] = function($groupTag) {
            $items[] = [
                'title' => 'Category Name',
                'type' => 'Text',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Enable Category',
                'type' => 'Switch',
                'accessor' => 'is_active'
            ];

            $itemsGroups = [];

            $dynAttrs = DynamicAttribute::with(['options'])->where('parent_table', 'categories')
                ->where('enabled', 1)
                ->get();

            foreach($dynAttrs as $item) {
                if (empty($item->admin_group)) {
                    $items[] = [
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'type' => empty($item->admin_component) ? 'Text' : $item->admin_component,
                        'accessor' => $item->attribute_name,
                        'options'  => $this->mapOptions($item->options)
                    ];
                } else {
                    $group = $item->admin_group;
                    if (!isset($itemsGroups[$group])) {
                        $itemsGroups[$group] = [];
                    }
                    $itemsGroups[$group][] = [
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'type' => empty($item->admin_component) ? 'Text' : $item->admin_component,
                        'accessor' => $item->attribute_name,
                        'options'  => $this->mapOptions($item->options)
                    ];
                }
            }
            
            AdminService::registerGroup($groupTag, 'category',  [
                'title' => 'Category Settings',
                'items' => $items
            ]);
            foreach($itemsGroups as $group => $items) {
                AdminService::registerSubgroupToGroup($groupTag, 
                    'category', 
                    md5($group), 
                    [
                        'title' => $group,
                        'items' => $items
                    ]);
            }
            // AdminService::registerSubgroupToGroup($groupTag, 'category', 'seo', [
            //     'title' => 'Search Engine Optimization ',
            //     'items' => [
            //         [
            //             'title' => 'Url Key',
            //             'type' => 'LongText',
            //             'accessor' => 'url_key'
            //         ]
            //     ]
            // ]);
        };

        $groups['catalog/product'] = function($groupTag) {
            $items[] = [
                'title' => 'Product Name',
                'type' => 'Text',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Enable Product',
                'type' => 'Switch',
                'accessor' => 'is_active'
            ];

            $itemsGroups = [];

            $relationFields = \Zento\Catalog\Model\ORM\Product::getPreloadRelations();
            foreach($relationFields ?? [] as $fields) {
                $items[] = [
                    'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                    'type' => empty($item->admin_component) ? 'Text' : $item->admin_component,
                    'accessor' => $item->attribute_name,
                    'options'  => $this->mapOptions($item->options)
                ];
            }

            $dynAttrs = DynamicAttribute::with(['options'])->where('parent_table', 'products')
                ->where('enabled', 1)
                ->get();

            foreach($dynAttrs as $item) {
                if (empty($item->admin_group)) {
                    $items[] = [
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'type' => empty($item->admin_component) ? 'Text' : $item->admin_component,
                        'accessor' => $item->attribute_name,
                        'options'  => $this->mapOptions($item->options)
                    ];
                } else {
                    $group = $item->admin_group;
                    if (!isset($itemsGroups[$group])) {
                        $itemsGroups[$group] = [];
                    }
                    $itemsGroups[$group][] = [
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'type' => empty($item->admin_component) ? 'Text' : $item->admin_component,
                        'accessor' => $item->attribute_name,
                        'options'  => $this->mapOptions($item->options)
                    ];
                }
            }
            
            AdminService::registerGroup($groupTag, 'product',  [
                'title' => 'Product Settings',
                'items' => $items
            ]);
            foreach($itemsGroups as $group => $items) {
                AdminService::registerSubgroupToGroup($groupTag, 
                    'product', 
                    md5($group), 
                    [
                        'title' => $group,
                        'items' => $items
                    ]);
            }
        };
    }

    protected function mapOptions($optionCollection) {
        $options = [];
        foreach($optionCollection ?? [] as $item) {
            $options[] = ['label' => $item['value'], 'value' => ('' . $item['id'])];
        }
        return $options;
    }
}