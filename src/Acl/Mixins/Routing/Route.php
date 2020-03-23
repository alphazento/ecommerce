<?php

namespace Zento\Acl\Mixins\Routing;

class Route {
    public function catalog() {
        return function() {
            return $this->action['catalog'] ?? 'guest';
        };
    }

    public function scope() {
        return function() {
            return $this->action['scope'] ?? 'unknow';
        };
    }
}