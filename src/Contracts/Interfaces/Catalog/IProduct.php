<?php

namespace Zento\Contracts\Interfaces\Catalog;

interface IProduct extends \Zento\Contracts\AssertAbleInterface
{
    const PROPERTIES = [
        'id', 
        'morph_type',
        'has_options',
        'required_options',
        'active',
        'status',
        'created_at',
        'updated_at',
        'tax_class_id',
        'visibility',
        // 'model',
        // 'dimension',
        // 'manufacturer',
        // 'url_path',
        'image',
        'gift_message_available',
        // 'minimal_price',
        'weight',
        // 'is_recurring',
        // 'quantity_and_stock_status',
        // 'country_of_manufacture',
        // 'news_from_date',
        // 'news_to_date',
        'name',
        'description',
        'short_description',
        'rrp',
        'cost',
        'price',
        'special_price',
        'special_from',
        'special_to'
    ];


    /**
     * check if shopping cart has same item exists
     *
     * @param IShoppingCart $cart
     * @param array $options
     * @return boolean
     */
    public function findExistCartItem(IShoppingCart $cart, array &$options);

    /**
     * prepare to item
     *
     * @param array $options
     * @return void
     */
    public function prepareToCartItem(array &$options);

    /**
     * get actual products from options
     *
     * @param array $options shopping cart item options
     * @return void
     */
    public function actualProductsInCart(array $options, $toArray = false);

    /**
     * for other type products will need to lazy load extra relation
     */
    public static function assignExtraRelation($products);
}