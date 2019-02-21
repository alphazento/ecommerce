<?php

namespace Zento\Backend\Config;

abstract class AbstractAdminConfig {
    abstract public function registerMenus();
    public function registerGroups($l0name, $l1name) {
        $groupTag = strtolower(sprintf('%s/%s', $l0name, $l1name));
        $groups = [];
        $this->_registerGroups($groupTag, $groups);
        foreach($groups as $l0l1name => $cb) {
            if ($groupTag === strtolower($l0l1name)) {
                call_user_func($cb, $groupTag);
            }
        }
        return $groupTag;
    }
    abstract protected function _registerGroups($groupTag, &$groups);
}