<?php

namespace Zento\CMS\View;

use Request;
use CategoryService;
class Category {
	public function load($viewName, $settings, &$extraData) {
		$ids = $extraData['category_ids'];
		$data = ['category_id'=>$ids[0], 'child_id' => last($ids)];
		$rootCategory = CategoryService::getCategoryById($data['category_id']);
		if (!$rootCategory) {
			throw new \Exception('category not found');
		}

		$categories = CategoryService::getCategoriesByLevel($rootCategory->level);
		foreach ($categories as $category) {
			echo '<pre>';
			print_r($category->toArray());die;
			$children_data = $this->loadChildren($category);

			// $filter_data = array(
			// 	'filter_category_id'  => $category->id,
			// 	'filter_sub_category' => true
			// );

			$data['categories'][] = array(
				'category_id' => $category->id,
				'name' => $category->name . (config('config_product_count', true) ? ' (' . $category->products_count. ')' : ''),
				'children'    => $children_data,
				'href'        => $category->url_path,
				// 'filter_data' => $filter_data
			);
		}
		$extraData['categories'] = $data['categories'];
		return ['extension.module.' . $viewName, $data];
	}

	protected function loadChildren($category) {
		$children_data = [];
		$children = $category->childrenCategories;
		foreach($children as $child) {
			// $filter_data = array('filter_category_id' => $child->id, 'filter_sub_category' => true);

			$item = [
				'category_id' => $child->id,
				'name' => $child->name . (config('config_product_count', true) ? ' (' . $child->products_count. ')' : ''),
				'href' => $child->url_path,
				// 'filter_data' => $filter_data
			];
			if ($child->childrenCategories && $child->childrenCategories->count() > 0) {
				$item['children'] = $this->loadChildren($child);
			}
			$children_data[] = $item;
		}
		return $children_data;
	}
}