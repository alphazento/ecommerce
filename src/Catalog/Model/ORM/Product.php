<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Database\Eloquent\Model;
use ShareBucket;
use Zento\Catalog\Model\ORM\Category\CategoryProductLink;
use Zento\Catalog\Model\ORM\Concerns\TraitCartProduct;
use Zento\Catalog\Model\ORM\Concerns\TraitProductPrice;
use Zento\Catalog\Model\ORM\Concerns\TraitProductTag;
use Zento\Contracts\Interfaces\Catalog\IProduct;
use Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
use Zento\Kernel\Support\Traits\SelfMorphModel;

class Product extends Model implements IProduct
{
    use DynamicAttributeAbility;
    use SelfMorphModel;
    use TraitCartProduct;
    use TraitProductPrice;
    use TraitProductTag;

    const MODEL_TYPE = "simple";

    protected $fillable = [
        'name',
        'attribute_set_id',
        'sku',
        'morph_type',
        'active',
    ];

    public function getRichDataDefines()
    {
        if (ShareBucket::get(\Zento\Kernel\Consts::ZENTO_PORTAL) === 'admin') {
            return [
                'prices',
                'special_prices',
            ];
        } else {
            return ['price'];
        }
    }

    public function getTableFields()
    {
        return $this->fillable;
    }

    public function shippable()
    {
        return true;
    }

    /**
     * base on type id, some inheritence class may not load some relationshop
     *
     * @return void
     */
    protected function lazyLoadRelation()
    {
        //do nothing for simple product
    }

    /**
     * all its categories
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, CategoryProductLink::class, 'product_id', 'id', 'id', 'category_id')
            ->orderBy('level');
    }

    public static function assignExtraRelation($products)
    {
        $reduced = array_filter($products, function ($product) {
            return $product->morph_type === static::MODEL_TYPE;
        });
        $ids = array_map(function ($product) {
            return $product->id;
        }, $reduced);
        return [$reduced, $ids];
    }
}
