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
                'ui' => 'config-text-item',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Enable Category',
                'ui' => 'config-boolean-item',
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
                        'ui' => empty($item->admin_component) ? 'config-text-item' : $item->admin_component,
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
                        'ui' => empty($item->admin_component) ? 'config-text-item' : $item->admin_component,
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
            //             'ui' => 'config-longtext-item',
            //             'accessor' => 'url_key'
            //         ]
            //     ]
            // ]);
        };

        $groups['catalog/product'] = function($groupTag) {
            $items[] = [
                'title' => 'Name',
                'ui' => 'config-text-item',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Enable Product',
                'ui' => 'config-boolean-item',
                'accessor' => 'is_active'
            ];

            $items[] = [
                'title' => 'Visibility',
                'ui' => 'config-options-item',
                'accessor' => 'visibility',
                'options' => [
                    ['label' => 'Not Visible Individually', 'value' => 1],
                    ['label' => 'Catalog', 'value' => 2],
                    ['label' => 'Search', 'value' => 3],
                    ['label' => 'Catalog, Search', 'value' => 4],
                ]
            ];

            $items[] = [
                'title' => 'Description',
                'ui' => 'config-longtext-item',
                'accessor' => 'description',
            ];
            
            $itemsGroups = ['Price' => [], 'Search Engine Optimization'=>[]];
            $itemsGroups['Price'][] = [
                'title' => 'Price',
                'ui' => 'config-text-item',
                'accessor' => 'price',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'RRP',
                'ui' => 'config-text-item',
                'accessor' => 'rrp',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Cost',
                'ui' => 'config-text-item',
                'accessor' => 'cost',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special Price',
                'ui' => 'config-text-item',
                'accessor' => 'special_price',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special From',
                'ui' => 'config-text-item',
                'accessor' => 'special_from',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special To',
                'ui' => 'config-text-item',
                'accessor' => 'special_to',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Description',
                'ui' => 'config-text-item',
                'accessor' => 'meta_description',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Title',
                'ui' => 'config-text-item',
                'accessor' => 'meta_description',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Keyword',
                'ui' => 'config-text-item',
                'accessor' => 'meta_keyword',
            ];

            $dynAttrs = DynamicAttribute::with(['options'])->where('parent_table', 'products')
                ->where('enabled', 1)
                ->get();

            foreach($dynAttrs as $item) {
                if ('visibility' == $item->attribute_name) {
                    continue;
                }
                if (empty($item->admin_group)) {
                    $items[] = [
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'ui' => empty($item->admin_component) ? 'config-text-item' : $item->admin_component,
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
                        'ui' => empty($item->admin_component) ? 'config-text-item' : $item->admin_component,
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