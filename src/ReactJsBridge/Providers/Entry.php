<?php

namespace Zento\ReactJsBridge\Providers;

use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        if (!$this->app->runningInConsole()) {
            
        }
    }
}
