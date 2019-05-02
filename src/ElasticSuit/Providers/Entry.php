<?php

namespace Zento\ElasticSuit\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\ElasticSuit\Elasticsearch\Connection;
use DB;

class Entry extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['db']->extend('elasticsearch', function($config, $name) {
            return new Connection($config['database'], $config['prefix'], $config);
        });
    }

}
