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

    protected function _registerGroups($groupTag, &$groups) {
        $this->mappingCategoryModelDefines($groupTag, $groups);
        $this->mappingProductModelDefines($groupTag, $groups);
        $this->mappingCategoryDatatableDefines($groupTag, $groups);
        $this->mappingProductDatatableDefines($groupTag, $groups);
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

    protected function mappingCategoryModelDefines($groupTag, &$groups) {
        $groups['catalog/category'] = function($groupTag) {
            $items[] = [
                'title' => 'Category Name',
                'ui' => 'config-text-item',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Active',
                'ui' => 'config-boolean-item',
                'accessor' => 'active'
            ];

            $items[] = [
                'title' => 'Attribute Set',
                'ui' => 'config-options-item',
                'accessor' => 'attribute_set_id',
                'options'  => $this->genAttributeSetOptions('categories')
            ];


            $daSets = DynamicAttributeSet::with('attributes')
                ->where('model', '=', 'categories')
                ->where('active', 1)
                ->get();

            //not display, but for the logic
            AdminConfigurationService::registerGroup($groupTag, '_extra_', $daSets->toArray());
            $itemsGroups = [];

            $this->groupDynamicAttributes('categories', $itemsGroups, $items);

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
    }

    protected function mappingProductModelDefines($groupTag, &$groups) {
        $groups['catalog/product'] = function($groupTag) {
            $items[] = [
                'title' => 'Name',
                'ui' => 'config-text-item',
                'accessor' => 'name'
            ];
            $items[] = [
                'title' => 'Attribute Set',
                'ui' => 'config-options-item',
                'accessor' => 'attribute_set_id',
                'options'  => $this->genAttributeSetOptions('products')
            ];
            $items[] = [
                'title' => 'Active',
                'ui' => 'config-boolean-item',
                'accessor' => 'active'
            ];

            $items[] = [
                'title' => 'Description',
                'ui' => 'config-longtext-item',
                'accessor' => 'description',
            ];
            
            // $itemsGroups = ['Price' => [], 'Search Engine Optimization'=>[]];
            // $itemsGroups['Price'][] = [
            //     'title' => 'Price',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'price',
            // ];

            // $itemsGroups['Price'][] = [
            //     'title' => 'RRP',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'rrp',
            // ];

            // $itemsGroups['Price'][] = [
            //     'title' => 'Cost',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'cost',
            // ];

            // $itemsGroups['Price'][] = [
            //     'title' => 'Special Price',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'special_price',
            // ];

            // $itemsGroups['Price'][] = [
            //     'title' => 'Special From',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'special_from',
            // ];

            // $itemsGroups['Price'][] = [
            //     'title' => 'Special To',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'special_to',
            // ];

            // $itemsGroups['Search Engine Optimization'][] = [
            //     'title' => 'Meta Description',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'meta_description',
            // ];

            // $itemsGroups['Search Engine Optimization'][] = [
            //     'title' => 'Meta Title',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'meta_description',
            // ];

            // $itemsGroups['Search Engine Optimization'][] = [
            //     'title' => 'Meta Keyword',
            //     'ui' => 'config-text-item',
            //     'accessor' => 'meta_keyword',
            // ];

            $this->groupDynamicAttributes('products', $itemsGroups, $items);

            AdminConfigurationService::registerGroup($groupTag, 'basic',  [
                'title' => 'Basic Settings',
                'items' => $items
            ]);

            $daSets = DynamicAttributeSet::with('attributes')
                ->where('model', '=', 'products')
                ->where('active', 1)
                ->get();
            //not display, but for the logic
            AdminConfigurationService::registerGroup($groupTag, '_extra_', $daSets->toArray());

            foreach($itemsGroups as $group => $items) {
                AdminConfigurationService::registerGroup($groupTag, 
                    $group, 
                    [
                        'title' => $group,
                        'items' => $items
                    ]);
            }
        };
    }

    protected function mappingCategoryDatatableDefines($groupTag, &$groups) {
        $groups['tables/category'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'table',  [
                'title' => 'Category DataTable Template Definition',
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
    }

    protected function mappingProductDatatableDefines($groupTag, &$groups) {
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
                            'clearable' => true,
                        ],
                        [
                            'text' => 'Visibility',
                            'ui' => 'z-options-display',
                            'value' => 'visibility',
                            'options' => $this->getProductVisibilityOptions(),
                            'filter_ui' => 'config-options-item',
                            'clearable' => true,
                        ],
                        [
                            'text' => 'Active',
                            'ui' => 'z-boolean-chip',
                            'value' => 'Active',
                            'filter_ui' => 'config-boolean-item'
                        ],
                        // [
                        //     'text' => 'Image',
                        //     'ui' => 'config-image-uploader-item',
                        //     'visibility' => 'public',
                        //     'folder' => 'website',
                        //     'accept' => 'image/png, image/jpeg, image/jpg, image/bmp, image/gif, image/svg+xml',
                        //     'fileType' => 'png,jpeg,jpg,bmp,gif,ico,svg',
                        //     'value' => 'image'
                        // ],
                        [
                            'text' => 'Image',
                            'ui' => 'z-image',
                            'value' => 'image',
                            'maxWidth' => '150px'
                        ],
                        [
                            'text' => 'Actions',
                            'ui' => 'z-config-actions',
                            'value' => '_none_',
                            'options' => [
                                [
                                    'label' => 'Edit',
                                    'value' => 'editProduct'
                                ],
                                [
                                    'label' => 'Delete',
                                    'value' => 'deleteProduct'
                                ],
                            ]
                        ]
                    ],
                    'primary_key' => 'id',
                ]
            ]);
        };
    }

    protected function mapOptions($optionCollection) {
        $options = [];
        foreach($optionCollection ?? [] as $item) {
            $options[] = ['label' => $item['value'], 'value' => ('' . $item['id'])];
        }
        return $options;
    }

    protected function genAttributeSetOptions($model) {
        $collection = DynamicAttributeSet::where('model', '=', $model)
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
    protected function getProductVisibilityOptions() {
        return [
            ['label' => 'Not Visible Individually', 'value' => 1],
            ['label' => 'Catalog', 'value' => 2],
            ['label' => 'Search', 'value' => 3],
            ['label' => 'Catalog, Search', 'value' => 4],
        ];
    }

    protected function buildConfigItem($dynAttr) {
        $item = [
            'da_id' => $dynAttr->id,
            'title' => empty($dynAttr->admin_label) ? $dynAttr->attribute_name : $dynAttr->admin_label,
            'ui' => empty($dynAttr->admin_component) ? 'config-text-item' : $dynAttr->admin_component,
            'accessor' => $dynAttr->attribute_name,
            'options'  => $this->mapOptions($dynAttr->options)
        ];
        if ($item['ui'] === 'config-image-uploader-item') {
            $item['visibility'] = 'public';
            $item['folder'] = 'catalog';
            $item['accept'] = 'image/png, image/jpeg, image/jpg, image/bmp, image/gif, image/svg+xml';
            $item['fileType'] = 'png,jpeg,jpg,bmp,gif,ico,svg';
        }
        return $item;
    }
    protected function groupDynamicAttributes($model, &$itemsGroups, &$items) {
        $dynAttrs = DynamicAttribute::with(['options'])
        ->where('parent_table', $model)
        ->where('active', 1)
        ->get();

        foreach($dynAttrs as $item) {
            if (empty($item->admin_group)) {
                $items[] = $this->buildConfigItem($item);
            } else {
                $group = $item->admin_group;
                if (!isset($itemsGroups[$group])) {
                    $itemsGroups[$group] = [];
                }
                $itemsGroups[$group][] = $this->buildConfigItem($item);
            }
        }
    }
}