<?php

namespace Zento\Backend\Http\Controllers\Api;

use Zento\Kernel\Facades\PackageManager;

trait TraitHelper
{
    protected function traversePackages(\Closure $callback) {
        $ret = '';
        if ($enabledPackageConfigs = PackageManager::loadPackagesConfigs()) {
            foreach($enabledPackageConfigs as $packageConfig) {
                $namespace = (PackageManager::getNameSpace($packageConfig['name']));
                $className = sprintf('\\%s\\Config\\Admin', $namespace);
                if (class_exists($className)) {
                    $ret = $callback($className);
                }
            }
        }
        return $ret;
    }
}
