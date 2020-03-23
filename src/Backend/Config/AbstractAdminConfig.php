<?php

namespace Zento\Backend\Config;

abstract class AbstractAdminConfig {
    /**
     * register configuration menus
     */
    public function registerDashboardMenus() {

    }
    
    /**
     * register configuration menus
     */
    public function registerConfigMenus() {

    }

    public function registerGroups($l0name, $l1name) {
        $groupTag = strtolower(sprintf('%s/%s', $l0name, $l1name));
        // $groups = [];
        // $this->_registerDataTableSchema($groupTag, $groups);
        // foreach($groups as $l0l1name => $cb) {
        //     if ($groupTag === strtolower($l0l1name)) {
        //         call_user_func($cb, $groupTag);
        //     }
        // }

        $groups = [];
        $this->_registerGroups($groupTag, $groups);
        foreach($groups as $l0l1name => $cb) {
            if ($groupTag === strtolower($l0l1name)) {
                call_user_func($cb, $groupTag);
            }
        }
        return $groupTag;
    }

    protected function defineDataTableSchemas($groupTag, &$groups) {

    }
    protected function defineModels($groupTag, &$groups) {}

    protected function _registerGroups($groupTag, &$groups) {}
}