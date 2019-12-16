<?php

namespace Zento\SnsConnect;

use Illuminate\Support\ServiceProvider;
use Zento\BladeTheme\Facades\BladeTheme;

class Provider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            BladeTheme::appendStubProcessor(function($stub) {
                if ($stub === 'sns_login') {
                    echo '<hello-sns></hello-sns>';
                }
            });

            BladeTheme::registerPreRouteCallAction(function($bladeTheme) {
                // prepare cateogry tree for category menus
                $bladeTheme->addGlobalViewData(
                    [
                        'consts' => [
                            'hellosns' => [
                                [
                                    'service' => 'facebook',
                                    'client_id' => '158217231362602',
                                    'color' => '#5168A4',
                                    'icon' => 'mdi-facebook',
                                    'title' => 'Continue With Facebook',
                                    'active' => true
                                ],
                                [
                                    'service' => 'linkedin',
                                    'client_id' => '158217231362602',
                                    'color' => '#278CAE',
                                    'icon' => 'mdi-linkedin',
                                    'title' => 'Continue With Linkedin',
                                    'active' => true
                                ],
                                [
                                    'service' => 'google',
                                    'client_id' => '158217231362602',
                                    'color' => '#278CAE',
                                    'icon' => 'mdi-google',
                                    'title' => 'Continue With Google',
                                    'active' => false
                                ]
                            ]
                        ]
                    ]
                );
            });
        }
    }
}
