<?php

namespace Zento\ConfigurableProduct\Providers;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        \Zento\Catalog\Model\ORM\Product::registerType('configurable',
             '\Zento\ConfigurableProduct\Model\ORM\Product');
    }
}
