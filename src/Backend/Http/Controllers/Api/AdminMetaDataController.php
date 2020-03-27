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
     * retrieve dashboard datatable component's schema defines
     * @group Dashboard
     * @authenticated
     * @urlParam model required The table name
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":{
     * "headers":[
     * {"text":"ID",
     * "ui":"z-label",
     * "value":"id",
     * "filter_ui":"config-text-item",
     * "clearable":true
     * }],
     * "primary_key":"id"}
     * }
     */
    public function datatableSchema() {
        $tableName = Route::input('table');
        $this->traversePackages(function($className) use($tableName) {
            (new $className)->registerDataTableSchemas($tableName);
        });
        if ($data = AdminConfigurationService::getDetailGroup($tableName)) {
            return $this->withData($data);
        } else {
            return $this->error(404, 'schema not found.');
        }
    }

    /**
     * retrieve dashboard model-editor component's model's defines
     * @group Dashboard
     * @authenticated
     * @urlParam model required The model name
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":{"basic":{"text":"group title",
     * "items":[{"text":"Name","ui":"config-text-item","accessor":"name"},
     * {"text":"Description","ui":"config-text-item","accessor":"description"},
     * {"text":"Active","ui":"config-boolean-item","accessor":"active"}]}}}
     */
    public function modelDefines() {
        $model = Route::input('model');
        $this->traversePackages(function($className) use($model) {
            (new $className)->registerModelDefines($model);
        });
        if ($data = AdminConfigurationService::getDetailGroup($model)) {
            return $this->withData($data);
        } else {
            return $this->error(404, 'model definition not found.');
        }
    }
}
