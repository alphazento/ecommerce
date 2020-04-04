<?php

namespace Zento\ApiDocAdv;

use Zento\ApiDocAdv\Console\ApidocGenerateSubscriber;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            with(new ApidocGenerateSubscriber)->subscribe();
        }
    }
}
