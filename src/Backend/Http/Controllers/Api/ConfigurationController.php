<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminService;
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
                (new $className)->registerMenus();
            }
        }
        return $this->withData(AdminService::getMeus());
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
        if ($groups = AdminService::getDetailGroup($key)) {
            return $this->getGroupValues($groups);
        } else {
            return $this->error(404, 'group not found.');
        }
    }

    protected function getGroupValues(&$groups) {
        foreach($groups as $name => &$group) {
            if ($group['items'] ?? false) {
                foreach($group['items'] as &$item) {
                    if ($accessor = $item['accessor']) {
                        $item['value'] = config($accessor);
                    }
                }
            }
            if ($group['subgroups'] ?? false) {
                foreach($group['subgroups'] as &$subgroups) {
                    foreach($subgroups['items'] ?? [] as &$item) {
                        if ($accessor = $item['accessor']) {
                            $item['value'] = config($accessor);
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
        Config::save($key, $value);
        return $this->with($key, $value);
    }
}
