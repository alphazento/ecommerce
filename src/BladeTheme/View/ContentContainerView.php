<?php
namespace Zento\BladeTheme\View;

use Illuminate\Contracts\View\View;

class ContentContainerView implements View {
    protected $name;
    protected $contents;
    public function __construct($fromView) {
        $this->name = 'combined-view:' . $fromView;
        $this->contents = [];
    }
    public function name() {
        return $this->name;
    }

    public function appendContent(string $content) {
        $this->contents[] = $content;
    }

    public function appendComment(string $comment) {
        $this->contents[] = sprintf('<!-- %s -->', $comment);
    }

    public function render() {
        return implode(' ', $this->contents);
    }

    public function with($key, $value = null){
        return $this;
    }

    public function getData() {
        return [];
    }
}
