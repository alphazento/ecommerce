<?php

namespace Zento\Catalog\Services;

use Zento\Catalog\Model\DB\Category as CategoryModel;
use Zento\Catalog\Model\DB\Category\Description;
use Zento\Catalog\Model\DB\PrinterCategory;
use DB;

class Category {
    public function load($id) {
        return CategoryModel::find($id);
    }

    public function brand($name) {
        return CategoryModel::join(
                    DB::raw((new Description())->getTable() . ' as jt '),
                    'jt.categories_id',
                    '=',
                    (new CategoryModel())->getTable() . '.categories_id')
                ->where('parent_id', '=', 0)
                ->where('jt.categories_name', '=', trim($name))
                ->first();
    }

    public function brands($status='Y') {
        $collection = CategoryModel::where('parent_id', '=', 0);
        if ($status != 'ALL') {
            $collection->where('status', '=', $status);
        }

        return $collection->get();
    }

    public function collection() {
        return (new CategoryModel)->newQuery();
    }

    public function url($idOrCat) {
        $cat = $idOrCat;
        if (is_string($idOrCat)) {
            $cat = CategoryModel::find($id);
        }

        if ($cat instanceof CategoryModel) {
            return '';
        }
        return null;
    }

    public function imageUrl($idOrCat) {

    }
}