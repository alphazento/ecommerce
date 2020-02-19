<?php

namespace Zento\Catalog\Config;

use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttributeSet;
use Zento\Catalog\Model\ORM\Product;

class Admin extends \Zento\Backend\Config\AbstractAdminConfig {
    public function registerDashboardMenus() {
        AdminDashboardService::registerRootLevelMenuNode('Catalog', 'Catalog', 'mdi-warehouse');
        AdminDashboardService::registerL1MenuNode('Catalog', 'Category', 'Category', 
            'mdi-sitemap', '/admin/catalog/category');
        AdminDashboardService::registerL1MenuNode('Catalog', 'Product', 'Product', 
            'mdi-shape', '/admin/catalog/product');
    }

    public function registerConfigMenus() {
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

            $items[] = [
                'title' => 'Attribute Set',
                'ui' => 'config-options-item',
                'accessor' => 'attribute_set_id',
                'options'  => $this->genAttributeSetOptions()
            ];


            $daSets = DynamicAttributeSet::with('attributes')
                ->where('model', '=', 'categories')
                ->where('active', 1)
                ->get();

            //not display, but for the logic
            AdminConfigurationService::registerGroup($groupTag, '_extra_', $daSets->toArray());
            $itemsGroups = [];

            $dynAttrs = DynamicAttribute::with(['options'])
                ->where('parent_table', 'categories')
                ->where('active', 1)
                ->get();

            foreach($dynAttrs as $item) {
                if (empty($item->admin_group)) {
                    $items[] = [
                        'da_id' => $item->id,
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
                        'da_id' => $item->id,
                        'title' => empty($item->admin_label) ? $item->attribute_name : $item->admin_label,
                        'ui' => empty($item->admin_component) ? 'config-text-item' : $item->admin_component,
                        'accessor' => $item->attribute_name,
                        'options'  => $this->mapOptions($item->options)
                    ];
                }
            }

            AdminConfigurationService::registerGroup($groupTag, 'basic',  [
                'title' => 'Basic Settings',
                'items' => $items
            ]);

            foreach($itemsGroups as $group => $items) {
                AdminConfigurationService::registerGroup($groupTag, 
                    $group, 
                    [
                        'title' => $group,
                        'items' => $items
                    ]);
            }
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
                ->where('active', 1)
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
            
            AdminConfigurationService::registerGroup($groupTag, 'product',  [
                'title' => 'Product Settings',
                'items' => $items
            ]);

            foreach($itemsGroups as $group => $items) {
                AdminConfigurationService::registerSubgroupToGroup($groupTag, 
                    'product', 
                    md5($group), 
                    [
                        'title' => $group,
                        'items' => $items
                    ]);
            }
        };

        $groups['tables/category'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Category Editor Template Definition',
                'items' => [
                    'headers' => [
                        [
                            'text' => 'ID',
                            'ui' => 'z-label',
                            'value' => 'id',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true
                        ],
                        [
                            'text' => 'SKU',
                            'ui' => 'z-label',
                            'value' => 'sku',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                        ],
                        [
                            'text' => 'Name',
                            'ui' => 'z-label',
                            'value' => 'name',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                        ]
                    ],
                    'primary_key' => 'id',
                ]
            ]);
        };

        $groups['tables/product'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Product Table Definition',
                'items' => [
                    'headers' => [
                        [
                            'text' => 'ID',
                            'ui' => 'z-label',
                            'value' => 'id',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true
                        ],
                        [
                            'text' => 'Sku',
                            'ui' => 'z-label',
                            'value' => 'sku',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                            'sortable' => false
                        ],
                        [
                            'text' => 'Name',
                            'ui' => 'z-label',
                            'value' => 'name',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                            'sortable' => false
                        ],
                        [
                            'text' => 'Product Type',
                            'ui' => 'z-options-display',
                            'value' => 'type_id',
                            'options' => $this->genProductTypsMapping(),
                            'filter_ui' => 'config-options-item',
                            'filter_data_type' => 'string',
                        ],
                        [
                            'text' => 'Status',
                            'ui' => 'z-label',
                            'value' => 'status',
                            'filter_ui' => 'config-text-item',
                            'clearable' => true,
                        ],
                       
                        [
                            'text' => 'Image',
                            'ui' => 'config-image-uploader-item',
                            'visibility' => 'public',
                            'folder' => 'website',
                            'accept' => 'image/png, image/jpeg, image/jpg, image/bmp, image/gif',
                            'value' => 'image'
                        ]
                    ],
                    'primary_key' => 'id',
                ]
            ]);
        };

        // $groups['tables/product'] = function($groupTag) {
        //     AdminConfigurationService::registerGroup($groupTag, 'table',  [
        //         'title' => 'Product Editor Template Definition',
        //         'items' => [
        //             'headers' => [
        //                 [
        //                     'text' => 'ID',
        //                     'ui' => 'z-label',
        //                     'value' => 'id',
        //                     'filter_ui' => 'config-text-item',
        //                     'clearable' => true
        //                 ],
        //                 [
        //                     'text' => 'SKU',
        //                     'ui' => 'z-label',
        //                     'value' => 'sku',
        //                     'filter_ui' => 'config-text-item',
        //                     'clearable' => true,
        //                 ],
        //                 [
        //                     'text' => 'Name',
        //                     'ui' => 'z-label',
        //                     'value' => 'name',
        //                     'filter_ui' => 'config-text-item',
        //                     'clearable' => true,
        //                 ]
        //             ],
        //             'primary_key' => 'id',
        //         ]
        //     ]);
        // };
    }

    protected function mapOptions($optionCollection) {
        $options = [];
        foreach($optionCollection ?? [] as $item) {
            $options[] = ['label' => $item['value'], 'value' => ('' . $item['id'])];
        }
        return $options;
    }

    protected function genAttributeSetOptions() {
        $collection = DynamicAttributeSet::where('model', '=', 'categories')
            ->where('active', 1)
            ->getQuery()
            ->get(['id', 'name'])
            ->all();
        $options = [];

        foreach($collection as $item) {
            $options[] = ['label' => $item->name, 'value' => $item->id];
        };
        return $options;
    }

    protected function genProductTypsMapping() {
       return  array_map(function($key) {
            return [
                'label' => $key,
                'value' => $key
            ];
        }, array_keys(Product::getProductTypes()));
    }
}