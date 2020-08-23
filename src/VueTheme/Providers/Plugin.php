<?php

namespace Zento\VueTheme\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Storage;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\BladeTheme\Http\Controllers\CatalogController;
use Zento\BladeTheme\Http\Controllers\GeneralController;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Facades\ThemeManager;
use Zento\StoreFront\Consts as StoreFrontConsts;
use Zento\VueTheme\Consts as VueThemeConsts;
use Zento\VueTheme\Http\Controllers\CatalogController as VueThemeCatalogController;
use Zento\VueTheme\Http\Controllers\GeneralController as VueThemeGeneralController;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CatalogController::class, VueThemeCatalogController::class);
        $this->app->bind(GeneralController::class, VueThemeGeneralController::class);

        ThemeManager::whenSetTheme('Zento_VueTheme', function ($app) {
            $viewLocation = sprintf('%s/notifications', PackageManager::packageViewsPath('Zento_VueTheme'));
            $app['view']->addNamespace('notifications', $viewLocation);
        });
    }

    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            BladeTheme::registerPreRouteCallAction(function ($bladeTheme) {
                // prepare cateogry tree for category menus
                $apiResp = $bladeTheme->requestInnerApi('GET', $bladeTheme->apiUrl('catalog/categories/tree'));
                $footer = config(VueThemeConsts::CONFIG_KEY_FOOTER_DATA, '{}');
                $logo = config(StoreFrontConsts::LOGO);

                $disk = Storage::disk(config(StoreFrontConsts::PUBLIC_FILE_UPLOAD_STORAGE, 'public'));
                $baseUrl = Str::substr($disk->url(StoreFrontConsts::CATALOG_MEDIA_FOLDER), strlen(env('APP_URL')));
                $mediaLibs = ['catalog' => asset($baseUrl)];

                $bladeTheme->addGlobalViewData(
                    [
                        'categoryTree' => $apiResp->data,
                        'appData' => [
                            'theme' => compact('footer', 'logo'),
                            'mediaLibs' => $mediaLibs,
                            'user' => Auth::user(),
                        ],
                    ]
                );
            });
        }
    }
}
