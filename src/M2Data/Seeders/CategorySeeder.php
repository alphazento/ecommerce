<?php
namespace Zento\M2Data\Seeders;

use Illuminate\Support\Facades\DB;
use Zento\Catalog\Model\ORM\Category;
use Zento\Kernel\Facades\DynaColumnFactory;

class CategorySeeder extends \Illuminate\Database\Seeder {
    public function run()
    {
        $collection = \Zento\M2Data\Model\ORM\Category::with(['integerattrs.codedesc',
            'varcharattrs.codedesc', 
            'textattrs.codedesc',
            'datetimeattrs.codedesc',
            'decimalattrs.codedesc'])
            ->get();
        foreach($collection as $item) {
            $category = new Category();
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
            $category->description = '';
            // $category->save();

            foreach($item->integerattrs as $intItem) {
                $isSingle = $intItem->codedesc->front_input !== 'select';
                DynaColumnFactory::createRelationShipORM($category,
                    $intItem->codedesc->attribute_code, ['integer'], 
                    $isSingle);
                
                if ($intItem->value) {
                    echo sprintf('%s code:%s value:%s' . PHP_EOL, $item->entity_id, $intItem->codedesc->attribute_code, $intItem->value);
                    DynaColumnFactory::single($category, $intItem->codedesc->attribute_code)->new($intItem->value);
                }
            }
        }
    }

    protected function getRealType($fieldType, $inputType) {
        // DynaColumnFactory::createRelationShipORM(\Zento\Kernel\TestModel::class, 
        //     'new_column', ['char', 32], true);
        // DynaColumnFactory::createRelationShipORM(\Zento\Kernel\TestModel::class, 
        //     'new_column1', ['char', 32], false);

                // DynaColumnFactory::single($collection, 'new_column')->new('OKOK');
        // DynaColumnFactory::option($collection, 'new_column1')->new('this is a test');
        // DynaColumnFactory::option($collection, 'new_column1')->setValues(['this is a test', 'newvalue']);
    }
}