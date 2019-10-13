<?php
namespace Zento\BladeTheme\View;

use Zento\BladeTheme\View\Factory;

interface ProcessorInterface {
    /**
     * return \Illuminate\Contracts\View\View | null
     */
    public function process(Factory $viewfactory, string $view, $data = [], $mergeData = []);
}