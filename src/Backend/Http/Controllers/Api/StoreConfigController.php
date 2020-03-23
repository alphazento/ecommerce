<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class StoreConfigController extends ApiBaseController
{
    use TraitHelper;

    /**
     * admin uri store-configurations side menus
     */
    public function menus() {
        $this->traversePackages(function($className) {
            (new $className)->registerDynamicConfigItemMenus();
        });
        return $this->withData(AdminConfigurationService::getMenus());
    }

    /**
     * config groups belongs to uri store-configurations side menu item
     */
    public function groups() {
        $key = $this->traversePackages(function($className) {
            return (new $className)->registerDynamicConfigItemGroups(Route::input('l0'), Route::input('l1'));
        });

        if ($groups = AdminConfigurationService::getDetailGroup($key)) {
            return $this->getGroupValues($groups);
        } else {
            return $this->error(404, 'config group not found.');
        }
    }

    protected function getGroupValues(&$groups) {
        foreach($groups as $name => &$group) {
            if ($group['items'] ?? false) {
                foreach($group['items'] as &$item) {
                    if ($accessor = $item['accessor'] ?? false) {
                        $item['value'] = config($accessor);
                        if ($item['value'] === null && isset($item['defaultValue'])) {
                            $item['value'] = $item['defaultValue'];
                        }
                    }
                }
            }
            if ($group['subgroups'] ?? false) {
                foreach($group['subgroups'] as &$subgroups) {
                    foreach($subgroups['items'] ?? [] as &$item) {
                        if ($accessor = $item['accessor'] ?? false) {
                            $item['value'] = config($accessor);
                            if ($item['value'] === null && isset($item['defaultValue'])) {
                                $item['value'] = $item['defaultValue'];
                            }
                        }
                    }
                }
            }
        }
        return $this->withData($groups);
    }

    /**
     * store configurable item value
     */
    public function store() {
        $key = Route::input('key');
        $value = Request::get('value');
        if (Request::get('is_json', false)) {
            $value = json_decode($value, true);
        }
        Config::save($key, $value);
        return $this->with($key, $value);
    }
}
