<?php

namespace Zento\CMS\View;

class TabGroup {
	public function load($settings, $viewName, $data) {
		static $module = 0;
		return ['block.tabgroup.' . $viewName , ['products' => $data]];
	}
}