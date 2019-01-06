<?php

namespace Zento\Backend\Http\Controllers\Api;

use Route;
use Request;
use Config;
use Zento\Backend\Providers\Facades\AdminService;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
    public function getMenus() {
        (new \Zento\Backend\Config\Admin())->registeConfigMenus();
        (new \Zento\PaypalPayment\Config\Admin())->registeConfigMenus();
        return ['status'=>200, 'data' => AdminService::getMeus()];
    }

    public function getMenuDetailGroups() {
        $key = (new \Zento\Backend\Config\Admin())->registerGroupIfMatchs(Route::input('l0'), Route::input('l1'));
        $key = (new \Zento\PaypalPayment\Config\Admin())->registerGroupIfMatchs(Route::input('l0'), Route::input('l1'));
        $key = (new \Zento\EwayPayment\Config\Admin())->registerGroupIfMatchs(Route::input('l0'), Route::input('l1'));
        return ['status'=>200, 'data' => AdminService::getDetailGroup($key)];
    }

    public function getConfigValues() {
        $keys = Request::get('keys');
        $values = [];
        foreach($keys as $key) {
            $values[$key] = config($key);
        }
        return ['status'=>200, 'data' => $values];
    }

    public function setConfigValue() {
        $key = Route::input('key');
        $value = Request::get('value');
        Config::save($key, $value);
        return ['status' => 200];
    }
}
