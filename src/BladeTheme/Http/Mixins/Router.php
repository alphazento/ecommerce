<?php

namespace Zento\BladeTheme\Http\Mixins;

class Router {
    public function setCurrent() {
        return function(\Illuminate\Routing\Route $route) {
            $this->current = $route;
        };
    }
}