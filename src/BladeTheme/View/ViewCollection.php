<?php
namespace Zento\BladeTheme\View;

class ViewCollection {
    protected $toDelete = [];
    protected $toReplace = [];

    public function addToDelete($viewName) {
        $this->toDelete[$viewName] = true;
    }

    public function addToReplace($viewName, $replace) {
        $this->toReplace[$viewName] = $replace;
    }

    public function isDeleted($viewName) {
        return $this->toDelete[$viewName] ?? false;
    }

    public function isReplaced($viewName) {
        return $this->toReplace[$viewName] ?? false;
    }
}
