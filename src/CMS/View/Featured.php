<?php

namespace Zento\CMS\View;

class Featured {
	public function load($settings) {
		return ['extension.module.featured' , ['products' => \Zento\Catalog\Model\ORM\Product::limit(4)->get()]];
	}
}