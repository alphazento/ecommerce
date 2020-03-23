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
    use TraitHelper;

    public function menus() {
        $this->traversePackages(function($className) {
            (new $className)->registerDashboardMenus();
        });
        return $this->withData(AdminDashboardService::getMenus());
    }
}
