<?php

namespace Zento\CMS\View;

class Banner {
	public function load($bannerId, $width, $height, $viewName = 'block.banner') {
		$banner = \Zento\CMS\Model\ORM\Banner::find($bannerId)->with('images')->first();
		return [$viewName, ['banners' => $banner->images]];
	}
}