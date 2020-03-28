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

    /**
     * retrieve dashboard menus
     * @group Dashboard
     * @authenticated
     * @no_acl
     * @response { "success":true,"code":200,"locale":"en","message":"",
     * "data": {"store":{"text":"Store","url":null,"icon":"mdi-store","items":{}}}
     * }
     */
    public function menus() {
        $this->traversePackages(function($className) {
            (new $className)->registerDashboardMenus();
        });
        return $this->withData(AdminDashboardService::getMenus());
    }
}
