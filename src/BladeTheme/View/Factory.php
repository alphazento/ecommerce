<?php
namespace Zento\BladeTheme\View;

class Factory extends \Illuminate\View\Factory
{
    protected $processors = [];

    public function __construct($app)
    {
        if ($app->bound('config')) {
            $config = $app->make('config');
            $viewFinder = $config->get('app.view_finder', 'view.finder');
        }

        parent::__construct($app['view.engine.resolver'], app($viewFinder), $app['events']);
        $this->setContainer($app);
        $this->share('app', $app);
    }

    public function addViewProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
        return $this;
    }

    public function make($view, $data = [], $mergeData = [])
    {
        foreach ($this->processors as $processor) {
            if ($result = $processor->process($this, $view, $data, $mergeData)) {
                if ($result instanceof \Illuminate\Contracts\View\View) {
                    return $result;
                }
            }
        }
        return parent::make($view, $data, $mergeData);
    }
}
