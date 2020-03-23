<?php

namespace Zento\Backend\Config;

abstract class AbstractAdminConfig {
    /**
     * register admin panel dashboard menus
     */
    final public function registerDashboardMenus() {
        $this->_registerDashboardMenus();
    }
    /**
     * register configuration item menus (for admin panel uri:  /store/configuration)
     */
    final public function registerDynamicConfigItemMenus() {
        $this->_registerDynamicConfigItemMenus();
    }

    /**
     * register configuration item group(for admin panel uri:  /store/configuration)
     */
    final public function registerDynamicConfigItemGroups($level0, $level1) {
        $groupTag = strtolower(sprintf('%s/%s', $level0, $level1));
        $groups = [];
        $this->_registerDynamicConfigItemGroups($groupTag, $groups);
        foreach($groups as $tag => $cb) {
            if ($groupTag === strtolower($tag)) {
                call_user_func($cb, $groupTag);
            }
        }
        return $groupTag;
    }

    final public function registerDataTableSchemas($dataTableName) {
        $items = [];
        $this->_registerDataTableSchemas($dataTableName);
        foreach($items as $tag => $cb) {
            if ($dataTableName === strtolower($tag)) {
                call_user_func($cb, $tag);
            }
        }
    }

    final public function registerModelDefines($modelName) {
        $items = [];
        $this->_registerModelDefines($modelName);
        foreach($items as $tag => $cb) {
            if ($modelName === strtolower($tag)) {
                call_user_func($cb, $tag);
            }
        }
    }

    /**
     * register dashboard menus
     */
    abstract protected function _registerDashboardMenus();

    /**
     * register configuration menus
     */
    abstract protected function _registerDynamicConfigItemMenus();

    abstract protected function _registerDataTableSchemas($dataTableName, &$groups);
    
    abstract protected function _registerModelDefines($dataTableName, &$groups);

    abstract protected function _registerDynamicConfigItemGroups($groupTag, &$groups);
}