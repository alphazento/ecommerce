<?php

namespace Zento\Backend\Http\Controllers\Api;

use Zento\Backend\Providers\Facades\AdminDashboardService;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class DashboardController extends ApiBaseController
{
    use TraitHelper;

    /**
     * Retrieves dashboard menus
     * @group Dashboard
     * @authenticated
     * @no_acl
     * @responsewith \Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute
     */
    public function menus()
    {
        $this->traversePackages(function ($className) {
            (new $className)->registerDashboardMenus();
        });
        return $this->withData(AdminDashboardService::getMenus());
    }
}
