<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminService;
use Zento\Kernel\Facades\PackageManager;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
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
        return ['status'=>200, 'data' => AdminService::getMeus()];
    }

    public function getConfigGroups() {
        $enabledPackageConfigs = PackageManager::loadPackagesConfigs();
        $key = '';
        foreach($enabledPackageConfigs ?? [] as $packageConfig) {
            $namespace = (PackageManager::getNameSpace($packageConfig->name));
            $className = sprintf('\\%s\\Config\\Admin', $namespace);
            if (class_exists($className)) {
                $key = (new $className)->registerGroups(Route::input('l0'), Route::input('l1'));
            }
        }
        return ['status'=>200, 'data' => AdminService::getDetailGroup($key)];
    }

    public function getGroupValues() {
        $groups = $this->getConfigGroups();
        $values = [];

        foreach($groups['data']??[] as $name => $group) {
            foreach($group['items'] ?? [] as $item) {
                $accessor = $item['accessor'];
                $values[$accessor] = config($accessor);
            }
            foreach($group['subgroups'] ?? [] as $subgroups) {
                foreach($subgroups['items'] ?? [] as $item) {
                    $accessor = $item['accessor'];
                    $values[$accessor] = config($accessor);
                }
            }
        }
        return ['status'=>200, 'data' => $values];
    }

    public function setConfigValue() {
        $key = Route::input('key');
        $value = Request::get('value');
        Config::save($key, $value);
        return ['status' => 200, 'data' => [$key => $value]];
    }
}
