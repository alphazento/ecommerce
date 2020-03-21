<?php

namespace Zento\Acl\Mixins\Routing;

class Route {
    public function role() {
        return function() {
            return $this->action['role'] ?? 'guest';
        };
    }

    public function scope() {
        return function() {
            return $this->action['scope'] ?? 'unknow';
        };
    }
}