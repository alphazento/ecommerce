<?php

namespace Zento\Acl\Mixins\Routing;

use Zento\Acl\Consts;

class Route
{
    public function acl()
    {
        return function () {
            return $this->action['acl'] ?? false;
        };
    }

    public function scope()
    {
        return function () {
            return $this->action['scope'] ?? Consts::UNDEFINED_SCOPE;
        };
    }
}
