<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class DashboardController extends ApiBaseController
{
    public function menus() {
        $enabledPackageConfigs = PackageManager::loadPackagesConfigs();
        foreach($enabledPackageConfigs ?? [] as $name => $packageConfig) {
            $namespace = (PackageManager::getNameSpace($name));
            $className = sprintf('\\%s\\Config\\Admin', $namespace);
            if (class_exists($className)) {
                (new $className)->registerDashboardMenus();
            }
        }
        return $this->withData(AdminDashboardService::getMenus());
    }
}
