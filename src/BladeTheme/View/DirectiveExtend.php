<?php

namespace Zento\BladeTheme\View;

use Illuminate\View\Factory;

class DirectiveExtend
{
    public function inject(Factory $viewFactory)
    {
        if ($bladeComplier = $viewFactory->getEngineResolver()->resolve('blade')->getCompiler()) {
            $bladeComplier->directive('asset', function ($key) {
                return sprintf('{{ asset(%s) }}', $key);
            });

            $bladeComplier->directive('stub', function ($expression) {
                return "<?php BladeTheme::processStub($expression, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>";
            });

            $bladeComplier->directive('remove', function ($key) {
                return sprintf('<?php BladeTheme::removeView(%s); ?>', $key);
            });

            $bladeComplier->directive('replace', function ($key) {
                return sprintf('<?php BladeTheme::replaceView(%s); ?>', $key);
            });

            $bladeComplier->directive('stub', function ($expression) {
                return "<?php BladeTheme::processStubs($expression); ?>";
            });
        }
        return $this;
    }
}
