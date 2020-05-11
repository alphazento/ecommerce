<?php

namespace Zento\StoreFront\Config;

use Zento\Backend\Config\AbstractAdminConfig;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\StoreFront\Consts;

class Admin extends AbstractAdminConfig
{
    protected $storages;

    protected function _registerDashboardMenus()
    {}

    protected function _registerDynamicConfigItemMenus()
    {
        AdminConfigurationService::registerLevel1MenuNode('Website', 'StoreFront');
    }

    protected function _registerDataTableSchemas(&$data)
    {}

    protected function _registerDynamicConfigItemGroups(&$data)
    {
        $data['website/storefront'] = function ($groupTag) {
            AdminConfigurationService::registerGroup([$groupTag, 'basic'], [
                'text' => 'Store Basic Settings',
                'items' => [
                    [
                        'text' => 'Logo',
                        'ui' => 'config-image-uploader-item',
                        'visibility' => 'public',
                        'folder' => 'website',
                        'accept' => 'image/png, image/jpeg, image/jpg, image/bmp, image/gif, image/svg+xml',
                        'fileType' => 'png,jpeg,jpg,bmp,gif,ico,svg',
                        'accessor' => Consts::LOGO,
                        'maxWidth' => '150px',
                    ],
                    [
                        'text' => 'Currency',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::CURRENCY,
                    ],
                    [
                        'text' => 'Assets Url Prefix',
                        'ui' => 'config-text-item',
                        'accessor' => Consts::ASSETS_URL_PREFIX,
                    ],
                ],
            ]);

            AdminConfigurationService::registerGroup([$groupTag, 'disks'], [
                'text' => 'Storage',
                'items' => [
                    [
                        'text' => 'Private File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' => $this->getStorages(),
                        'accessor' => Consts::PRIVATE_FILE_UPLOAD_STORAGE,
                    ],
                    [
                        'text' => 'Public File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' => $this->getStorages(),
                        'accessor' => Consts::PUBLIC_FILE_UPLOAD_STORAGE,
                    ],
                    [
                        'text' => 'Cloud Storage',
                        'ui' => 'config-options-item',
                        'options' => $this->getStorages(),
                        'accessor' => Consts::CLOUD_STORAGE,
                    ],
                ],
            ]);

            AdminConfigurationService::registerGroup([$groupTag, 'fileupload'], [
                'text' => 'File Upload',
                'items' => [
                    [
                        'text' => 'Public File Upload Storage',
                        'ui' => 'config-options-item',
                        'options' => [
                            [
                                'label' => 'Local Public only',
                                'value' => 'local',
                            ],
                            [
                                'label' => 'Cloud only',
                                'value' => 'cloud',
                            ],
                            [
                                'label' => 'Both Local and Cloud',
                                'value' => 'both',
                            ],
                        ],
                        'accessor' => Consts::PUBLIC_FILE_UPLOAD_STORE_STRATEGY,
                    ],
                    [
                        'text' => 'Private File Upload Public Storage',
                        'ui' => 'config-options-item',
                        'options' => [
                            [
                                'label' => 'Private Local only',
                                'value' => 'local',
                            ],
                            [
                                'label' => 'Cloud only',
                                'value' => 'cloud',
                            ],
                            [
                                'label' => 'Both Local and Cloud',
                                'value' => 'both',
                            ],
                        ],
                        'accessor' => Consts::PRIVATE_FILE_UPLOAD_STORE_STRATEGY,
                    ],
                ],
            ]);
        };
    }

    protected function _registerModelDefines(&$data)
    {}

    protected function getStorages()
    {
        if (!$this->storages) {
            $this->storages = [];
            $disks = config('filesystems.disks');
            foreach ($disks as $name => $configs) {
                unset($configs['key']);
                unset($configs['secret']);
                $this->storages[] = [
                    'label' => str_replace('\/', '/', sprintf('%s(%s)',
                        $name,
                        json_encode($configs, 1))),
                    'value' => $name,
                ];
            }
        }

        return $this->storages;
    }
}
