<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminConfigurationService;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class AdminMetaDataController extends ApiBaseController
{
    use TraitHelper;

    /**
     * get admin datatable components defines
     */
    public function datatableSchema() {
        $tableName = Route::input('table');
        $this->traversePackages(function($className) use($tableName) {
            (new $className)->registerDataTableSchemas($tableName);
        });
        if ($groups = AdminConfigurationService::getDetailGroup($tableName)) {
            return $groups;
        } else {
            return $this->error(404, 'schema not found.');
        }
    }
}
