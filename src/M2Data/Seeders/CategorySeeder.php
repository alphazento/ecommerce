<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Category;
use Zento\Kernel\Facades\DynaColumnFactory;

class CategorySeeder extends \Illuminate\Database\Seeder {
    use TraitEavHelper;

    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\Catalog\Category::with(['integerattrs.codedesc',
            'varcharattrs.codedesc', 
            'textattrs.codedesc',
            'datetimeattrs.codedesc',
            'decimalattrs.codedesc'])
            ->get();
        foreach($collection as $item) {
            $category = Category::find($item->entity_id);
            if (!$category) {
                $category = new Category();
            }
            $category->id = $item->entity_id;
            $category->dynacolumn_set_id = $item->attribute_set_id;
            $category->parent_id = $item->parent_id;
            $category->path = $item->path;
            $category->hash = md5($item->path);
            $category->position = $item->position;
            $category->level = $item->level;
            $category->children_count = $item->children_count;
            $category->active = true;
            $category->name = 'category' . $category->id;
            $category->image = '';
            $category->save();

            foreach(['integer','text', 'varchar', 'datetime', 'decimal'] as $ftype) {
                $relation = $ftype .'attrs';
                foreach($item->{$relation} ?? [] as $eavItem) {
                    if (!$eavItem->codedesc) {
                        continue;
                    }
                    if ($eavItem->codedesc->attribute_code == 'name') {
                        $category->name = $eavItem->value;
                        $category->update();
                    }
                    DynaColumnFactory::createRelationShipORM($category,
                        $eavItem->codedesc->attribute_code, [$ftype], 
                        $this->isSingleEav($eavItem->codedesc->frontend_input));
                    
                    if ($eavItem->value) {
                        DynaColumnFactory::single($category, $eavItem->codedesc->attribute_code)->new($eavItem->value);
                    }
                }
            }
        }
    }
}