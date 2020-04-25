<?php

namespace Zento\VueTheme;

use Auth;
use Storage;
use Zento\VueTheme\Consts as VueThemeConsts;
use Zento\StoreFront\Consts as StoreFrontConsts;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\Kernel\Facades\ThemeManager;
use Zento\Kernel\Facades\PackageManager;
use Zento\Catalog\Providers\Facades\ProductService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class Provider extends ServiceProvider
{
    public function register()
    {
        ThemeManager::whenSetTheme('Zento_VueTheme', function($app) {
            \Zento\BladeTheme\Http\Controllers\CatalogController::$OverwriteBy = '\Zento\VueTheme\Http\Controllers\CatalogController';
            \Zento\BladeTheme\Http\Controllers\GeneralController::$OverwriteBy = '\Zento\VueTheme\Http\Controllers\GeneralController';

            $viewLocation = sprintf('%s/notifications', PackageManager::packageViewsPath('Zento_VueTheme'));
            $app['view']->addNamespace('notifications', $viewLocation);
        });
    }
    
    public function boot() {
        if (!$this->app->runningInConsole()) {
            BladeTheme::registerPreRouteCallAction(function($bladeTheme) {
                // prepare cateogry tree for category menus
                $apiResp = $bladeTheme->requestInnerApi('GET', $bladeTheme->apiUrl('catalog/categories/tree'));
                $footer = config(VueThemeConsts::CONFIG_KEY_FOOTER_DATA, '{}');
                $logo = config(StoreFrontConsts::LOGO);
                
                $disk = Storage::disk(config(StoreFrontConsts::PUBLIC_FILE_UPLOAD_STORAGE, 'public'));
                $baseUrl = Str::substr($disk->url(StoreFrontConsts::CATALOG_MEDIA_FOLDER), strlen(env('APP_URL')));
                $mediaLibs = ['catalog' => asset($baseUrl)];

                $bladeTheme->addGlobalViewData(
                    [
                        'user' => Auth::user(),
                        'categoryTree' => $apiResp->data,
                        'appSettings' => [ 
                            'theme' => compact('footer', 'logo'),
                            'mediaLibs' => $mediaLibs
                        ]
                    ]
                );
            });
        }
    }
}
