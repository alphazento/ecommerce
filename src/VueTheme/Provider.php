<?php

namespace Zento\VueTheme;

use Auth;
use Config;
use Zento\VueTheme\Consts;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Kernel\Facades\ThemeManager;
use Zento\Kernel\Facades\PackageManager;
use Zento\Catalog\Providers\Facades\ProductService;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function register()
    {
        ThemeManager::whenSetTheme('Zento_VueTheme', function($app) {
            \Zento\BladeTheme\Http\Controllers\CatalogController::$OverwriteBy = '\Zento\VueTheme\Http\Controllers\CatalogController';
            \Zento\BladeTheme\Http\Controllers\GeneralController::$OverwriteBy = '\Zento\VueTheme\Http\Controllers\GeneralController';
            \Zento\BladeTheme\Services\BladeTheme::mixin(new \Baicy\DesktopTheme\Mixins\BladeTheme);

            $viewLocation = sprintf('%s/notifications', PackageManager::packageViewsPath('Zento_VueTheme'));
            $app['view']->addNamespace('notifications', $viewLocation);
        });
    }
    
    public function boot() {
        if (!$this->app->runningInConsole()) {
            BladeTheme::registerPreRouteCallAction(function($bladeTheme) {
                // prepare cateogry tree for category menus
                $apiResp = $bladeTheme->requestInnerApi('GET', $bladeTheme->apiUrl('categories/tree'));
                $footer = json_decode(Config::get(Consts::CONFIG_KEY_FOOTER_DATA, '{}'), true);
                $logo = Config::get(\Zento\StoreFront\Consts::LOGO);
                $bladeTheme->addGlobalViewData(
                    [
                        'user' => Auth::user(),
                        'category_tree' => $apiResp->data,
                        'themeData' => compact('footer', 'logo')
                    ]
                );
            });
        }
    }
}
