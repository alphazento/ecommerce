<?php

namespace Zento\CMS\Services;
use Zento\CMS\Model\ORM\Layout;
use Zento\CMS\View\Banner as BannerView;
class LayoutService {
    protected $positions;
	public function render($name, $pageView, $extraData) {
        $layout = Layout::where('name', $name)->first();
        $this->positions = [];
        foreach($layout->modules as $layoutModule) {
            if ($designModule = $layoutModule->getDesignModule()) {
                $position = $layoutModule->position;
                switch($designModule->code) {
                    case 'slideshow':
                    case 'carousel':
                    case 'banner':
                        $this->appendToPosition($position,
                            (new \Zento\CMS\View\Banner)->load(json_decode($designModule->setting, true), $designModule->code));
                    break;
                    case 'featured':
                        $this->appendToPosition($position,
                            (new \Zento\CMS\View\Featured)->load(json_decode($designModule->setting, true)));
                    break;
                }
            }
        }
        return view($pageView, array_merge($this->positions, $extraData));
    }
    
    protected function appendToPosition($position, $combination) {
        if ($combination) {
            if (!isset($this->positions[$position])) {
                $this->positions[$position] = [];
            }
            $this->positions[$position][] = $combination;
        }
    }
}