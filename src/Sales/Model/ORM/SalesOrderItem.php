<?php

namespace Zento\Sales\Model\ORM;

class SalesOrderItem extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'order_id',
        'name',
        'total',
    ];

    public static function recordItemsFromOrderQuote($order_id, $quote)
    {
        $data = [
            'order_id' => $order_id,
            'name' => 'Subtotal',
            'total' => $quote->subtotal,
        ];
        static::create($data);

        $data['name'] = 'Total';
        $data['total'] = $quote->total;
        static::create($data);

        $data['name'] = 'Shipping & Handling';
        $data['total'] = $quote->shipping_fee + $quote->handle_fee;
        static::create($data);

        $data['name'] = 'Tax';
        $data['total'] = $quote->tax_amount;
        static::create($data);
    }
}
