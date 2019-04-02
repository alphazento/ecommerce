<?php

namespace Zento\ReactApp\Providers;

use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Kernel\Facades\PackageManager;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        if ($this->app->runningInConsole()) {
            $buildFolder = PackageManager::packagePath('Zento_ReactApp', ['zentostore', 'build', 'static']);
            $this->publishes(
                [ $buildFolder => public_path('static')],
                'react-storefront'
            );
        }
    }
}
