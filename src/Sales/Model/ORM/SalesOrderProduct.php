<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Arr;

class SalesOrderProduct extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'order_id', 
        'name', 
        'product_id', 
        'sku', 
        'price',
        'custom_price',
        'quantity', 
        'shippable',
        'taxable',
        'unit_price', 
        'row_price',
        'refund',
        'actuals',
        'options',
        'active'
    ];

    public static function recordProductsFromOrderQuote($order_id, $quote) {
        foreach($quote->items ?? [] as $item) {
            $data = $item->toArray();
            $data = Arr::except($data, ['id', 'cart_id']);
            $data['order_id'] = $order_id;
            $data['actuals'] = $actuals;
            static::create($data);
        }
    }
}
