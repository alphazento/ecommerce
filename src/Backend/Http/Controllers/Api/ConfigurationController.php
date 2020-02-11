<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class ConfigurationController extends ApiBaseController
{
    public function getMenus() {
        $enabledPackageConfigs = PackageManager::loadPackagesConfigs();
        foreach($enabledPackageConfigs ?? [] as $name => $packageConfig) {
            $namespace = (PackageManager::getNameSpace($name));
            $className = sprintf('\\%s\\Config\\Admin', $namespace);
            if (class_exists($className)) {
                (new $className)->registerConfigMenus();
            }
        }
        return $this->withData(AdminConfigurationService::getMenus());
    }

    public function getConfigGroups() {
        $key = '';
        if ($enabledPackageConfigs = PackageManager::loadPackagesConfigs()) {
            foreach($enabledPackageConfigs as $packageConfig) {
                $namespace = (PackageManager::getNameSpace($packageConfig['name']));
                $className = sprintf('\\%s\\Config\\Admin', $namespace);
                if (class_exists($className)) {
                    $key = (new $className)->registerGroups(Route::input('l0'), Route::input('l1'));
                }
            }
        }
        if ($groups = AdminConfigurationService::getDetailGroup($key)) {
            $withValue = Request::get('withValue');
            return $this->getGroupValues($groups, $withValue);
        } else {
            return $this->error(404, 'group not found.');
        }
    }

    protected function getGroupValues(&$groups, $withValue) {
        foreach($groups as $name => &$group) {
            if ($group['items'] ?? false) {
                foreach($group['items'] as &$item) {
                    if ($withValue && ($accessor = $item['accessor'] ?? false)) {
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
                        if ($withValue && ($accessor = $item['accessor'] ?? false)) {
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

    public function setConfigValue() {
        $key = Route::input('key');
        $value = Request::get('value');
        if (Request::get('is_json', false)) {
            $value = json_decode($value, true);
        }
        Config::save($key, $value);
        return $this->with($key, $value);
    }
}
