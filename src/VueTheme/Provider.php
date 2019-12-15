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

                //prepare theme page footer and navigator drawer data
                $json = '{
                    "icons":[
                      {"icon":"fa-facebook","link":"https://facebook.com"},
                      {"icon":"fa-twitter","link":"https://twitter.com"},
                      {"icon":"fa-linkedin","link":"https://linkedin.com"},
                      {"icon":"fa-instagram","link":"https://instagram.com"}
                    ],
                    "links":[
                      {"title":"Home","link":"/"},
                      {"title":"About Us","link":"/about-us"},
                      {"title":"Team","link":"/team"},
                      {"title":"Services","link":"/services"},
                      {"title":"Privacy","link":"/privacy"},
                      {"title":"Blog","link":"/blog"},
                      {"title":"Contact Us","link":"/contact-us"}
                    ],
                    "company":{"name":"Alphazento","description":"Description of Alphazento"},
                    "copyright":2019
                  }';
                
                Config::set(Consts::FOOTER_CONFIG_KEY, $json);

                $footer = json_decode(Config::get(Consts::FOOTER_CONFIG_KEY, '{}'), true);
                $logo = Config::get(Consts::LOGO_CONFIG_KEY);
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
