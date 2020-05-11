<?php
namespace Zento\BladeTheme\Services\Concerns;

trait TraitViewStub
{
    protected $stubProcessors = [];

    public function appendStubProcessor(\Closure $callback)
    {
        $this->stubProcessors[] = $callback;
        return $this;
    }

    public function processStubs($name)
    {
        foreach ($this->stubProcessors ?? [] as $callback) {
            $callback($name);
        }
    }
}
