<?php

namespace Zento\StoreFront\Config;

use Zento\StoreFront\Consts;
use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;

class Admin extends AbstractAdminConfig {
    public function registerConfigMenus() {
        AdminConfigurationService::registerL1MenuNode('Website', 'StoreFront', 'StoreFront');
    }

    public function _registerGroups($groupTag, &$groups) {
        $groups['website/storefront'] = function($groupTag) {
            AdminConfigurationService::registerGroup($groupTag, 'basic',  [
                'title' => 'Store Basic Settings',
                'items' => [
                    [
                        'title' => 'Logo',
                        'ui' => 'config-image-uploader-item',
                        'visibility' => 'public',
                        'folder' => 'website',
                        'accept' => 'image/png, image/jpeg, image/jpg, image/bmp, image/gif',
                        'accessor' => Consts::LOGO
                    ],
                    [
                        'title' => 'Currency',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CURRENCY
                    ],
                    [
                        'title' => 'Assets Url Prefix',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::ASSETS_URL_PREFIX
                    ]
                ]
            ]);

            AdminConfigurationService::registerGroup($groupTag, 'disks',  [
                'title' => 'Storage',
                'items' => [
                    [
                        'title' => 'Private File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' =>  $this->getStorages(),
                        'accessor' => Consts::PRIVATE_FILE_UPLOAD_STORAGE
                    ],
                    [
                        'title' => 'Public File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' =>  $this->getStorages(),
                        'accessor' => Consts::PUBLIC_FILE_UPLOAD_STORAGE
                    ],
                    [
                        'title' => 'Cloud Storage',
                        'ui' => 'config-options-item',
                        'options' =>  $this->getStorages(),
                        'accessor' => Consts::CLOUD_STORAGE
                    ],
                ]
            ]);

            AdminConfigurationService::registerGroup($groupTag, 'fileupload',  [
                'title' => 'File Upload',
                'items' => [
                    [
                        'title' => 'Public File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' => [
                            [
                                'label' => 'Local Public only',
                                'value' => 'local'
                            ],
                            [
                                'label' => 'Cloud only',
                                'value' => 'cloud'
                            ],
                            [
                                'label' => 'Both Local and Cloud',
                                'value' => 'both'
                            ],
                        ],
                        'accessor' => Consts::PUBLIC_FILE_UPLOAD_STORE_STRATEGY
                    ],
                    [
                        'title' => 'Private File Upload Public Storage',
                        'ui' => 'config-options-item',
                        'options' => [
                            [
                                'label' => 'Private Local only',
                                'value' => 'local'
                            ],
                            [
                                'label' => 'Cloud only',
                                'value' => 'cloud'
                            ],
                            [
                                'label' => 'Both Local and Cloud',
                                'value' => 'both'
                            ],
                        ],
                        'accessor' => Consts::PRIVATE_FILE_UPLOAD_STORE_STRATEGY
                    ]
                ]
            ]);
        };
    }

    protected $storages;
    protected function getStorages() {
        if (!$this->storages) {
            $this->storages = [];
            $disks = config('filesystems.disks');
            foreach($disks as $name => $configs) {
                unset($configs['key']);
                unset($configs['secret']);
                $this->storages[] = [
                    'label' => str_replace('\/', '/', sprintf('%s(%s)', 
                        $name, 
                        json_encode($configs, 1))),
                    'value' => $name
                ];
            }
        }
        
        return $this->storages;
    }
}
