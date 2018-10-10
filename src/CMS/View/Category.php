<?php

namespace Zento\CMS\View;

use Request;
use CategoryService;
class Category {
	public function load($viewName, $settings, $category_ids) {
		$data['categories'] = CategoryService::tree();
		$data['category_id'] = $category_ids[0];
		$data['child_id'] = last($category_ids);
		return ['extension.module.' . $viewName, $data];
	}
}