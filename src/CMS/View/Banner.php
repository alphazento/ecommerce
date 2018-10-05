<?php

namespace Zento\CMS\View;

class Banner {
	public function load($settings, $viewName) {
		static $module = 0;
		$banner = \Zento\CMS\Model\ORM\Banner::find($settings['banner_id']);
		return ['extension.module.' . $viewName , ['banners' => $banner->images, 'module' => $module++]];
	}
}