<?php

namespace Zento\BladeTheme\View\Processer;

use Illuminate\Contracts\View\View;

use Zento\BladeTheme\View\Factory;
use Zento\BladeTheme\View\ProcessorInterface;
use Zento\BladeTheme\View\ContentContainerView;
use Zento\BladeTheme\Facades\BladeTheme;

class BladeViewEnhance implements ProcessorInterface {
    public function process(Factory $factory, string $view, $data = [], $mergeData = []) {
        $replaced = BladeTheme::isViewReplaced($view);
        $deleted = BladeTheme::isViewDeleted($view);
        if ($replaced || $deleted) {
            $contentContainer = new ContentContainerView($view);
            if ($replaced) {
                $contentContainer->appendContent($factory->make($factory, $data, $mergeData));
            }
            if ($deleted) {
                $contentContainer->appendComment($view);
            }
            return $contentContainer;
        }
        return false;
    }
}
