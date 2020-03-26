<?php

namespace Zento\Acl\Mixins\Routing;

class Route {
    public function acl() {
        return function() {
            return $this->action['acl'] ?? false;
        };
    }

    public function scope() {
        return function() {
            return $this->action['scope'] ?? 'unknow';
        };
    }
}