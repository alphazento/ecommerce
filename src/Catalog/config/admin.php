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
                'title' => 'Name',
                'type' => 'Text',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Enable Product',
                'type' => 'Switch',
                'accessor' => 'is_active'
            ];

            $items[] = [
                'title' => 'Visibility',
                'type' => 'SelectBox',
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
                'type' => 'LongText',
                'accessor' => 'description',
            ];
            
            $itemsGroups = ['Price' => [], 'Search Engine Optimization'=>[]];
            $itemsGroups['Price'][] = [
                'title' => 'Price',
                'type' => 'Text',
                'accessor' => 'price',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'RRP',
                'type' => 'Text',
                'accessor' => 'rrp',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Cost',
                'type' => 'Text',
                'accessor' => 'cost',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special Price',
                'type' => 'Text',
                'accessor' => 'special_price',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special From',
                'type' => 'Text',
                'accessor' => 'special_from',
            ];

            $itemsGroups['Price'][] = [
                'title' => 'Special To',
                'type' => 'Text',
                'accessor' => 'special_to',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Description',
                'type' => 'Text',
                'accessor' => 'meta_description',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Title',
                'type' => 'Text',
                'accessor' => 'meta_description',
            ];

            $itemsGroups['Search Engine Optimization'][] = [
                'title' => 'Meta Keyword',
                'type' => 'Text',
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