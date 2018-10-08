<?php

namespace Zento\CMS\Services;

use CategoryService;
use Zento\CMS\Model\ORM\Layout;
use Zento\CMS\View\Banner as BannerView;

class LayoutService {
    protected $positions;
	public function render($name, $pageView, $extraData) {
        $layout = Layout::where('name', $name)->first();
        $this->positions = [];
        foreach($layout->modules as $layoutModule) {
            $position = $layoutModule->position;
            if ($designModule = $layoutModule->getDesignModule()) {
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
            } else {
                switch($layoutModule->code) {
                    case 'category':
                    $this->appendToPosition($position,
                        (new \Zento\CMS\View\Category)->load('category', null, $extraData['category_ids']));
                    break;
                }
            }
        }
        $extraData['categories'] = CategoryService::tree();
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