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
            $items[] = [
                'title' => 'Meta Description',
                'type' => 'Text',
                'accessor' => 'meta_description',
            ];

            $items[] = [
                'title' => 'Meta Title',
                'type' => 'Text',
                'accessor' => 'meta_description',
            ];

            $items[] = [
                'title' => 'Meta Keyword',
                'type' => 'Text',
                'accessor' => 'meta_keyword',
            ];

            $items[] = [
                'title' => 'Price',
                'type' => 'Text',
                'accessor' => 'price',
            ];

            $items[] = [
                'title' => 'RRP',
                'type' => 'Text',
                'accessor' => 'rrp',
            ];

            $items[] = [
                'title' => 'Cost',
                'type' => 'Text',
                'accessor' => 'cost',
            ];

            $items[] = [
                'title' => 'Special Price',
                'type' => 'Text',
                'accessor' => 'special_price',
            ];

            $items[] = [
                'title' => 'Special From',
                'type' => 'Text',
                'accessor' => 'special_from',
            ];

            $items[] = [
                'title' => 'Special To',
                'type' => 'Text',
                'accessor' => 'special_to',
            ];

            $itemsGroups = [];

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