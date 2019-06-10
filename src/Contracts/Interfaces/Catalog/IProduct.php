<?php

namespace Zento\Contracts\Interfaces\Catalog;

interface IProduct extends \Zento\Contracts\AssertAbleInterface
{
    const PROPERTIES = [
        'id', 
        'type_id',
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
        'url_path',
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
}