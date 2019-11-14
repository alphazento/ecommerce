<?php

namespace Zento\PaypalPayment\Model;
use Carbon\Carbon;

class PaymentPrimer {
    /**Old version paypal express */
    public function getPaymentData0(\Zento\Contracts\Interfaces\Catalog\IShoppingCart $cart) {
        $details = [];
        $details['subtotal'] = $cart->subtotal;

        $items = [];
        foreach($cart->items as $item) {
            $attrs = [];
            $attrs['name'] = $item->name;
            $attrs['description'] = $item->description;
            $attrs['quantity'] = $item->quantity;
            $attrs['price'] = $item->unit_price;
            $attrs['sku'] = $item->product_id;
            $attrs['currency'] = 'AUD';
            $items[] = $attrs;
        }
        $details['shipping'] = $item->shipping_fee;
        // $details['handling'] = $item->handle_fee;
        $shippingaddress = $cart->shipping_address;
        // $shippingCountryCode = $shippingaddress->country;
        $shippingCountryCode = 'AU';

        $payment = [
            'intent' => 'sale', //'authorize'
            'payer' => [
                'payer_info' => [
                    'email' => $cart->email
                ]
            ],
            'transactions'=> [
                [
                    'amount'=> [
                            'total'=> $cart->total,
                            'currency'=> "AUD",
                            'details'=>  $details,
                        ],
                    "description" => "The payment transaction description.",
                    "custom" => $cart->customer_id,
                    "invoice_number" => sprintf('c%s %s', $cart->customer_id, Carbon::now()->timestamp),
                    "payment_options"=> [
                        // "allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
                        "allowed_payment_method" => "UNRESTRICTED"
                    ],
                    // "soft_descriptor"=> "",
                    "item_list"=>[
                        "items"=> $items,
                        // "shipping_address" => [
                        //     "recipient_name"=> $shippingaddress->name,
                        //     "line1"=> substr($shippingaddress->address1, 0, 100),
                        //     "line2"=> substr($shippingaddress->address2, 0, 100),
                        //     "city"=> substr($shippingaddress->city, 0, 64),
                        //     "country_code"=> $shippingCountryCode,
                        //     "postal_code"=> substr($shippingaddress->postal_code, 0, 30),
                        //     // "phone"=> '',
                        //     "state"=> substr($shippingaddress->state, 0, 40)
                        // ]
                        "shipping_address" => [
                            "recipient_name"=>'Tony Chen',
                            "line1"=> '100 St',
                            "line2"=> '',
                            "city"=> 'Sydney',
                            "country_code"=> 'AU',
                            "postal_code"=> 2000,
                            // "phone"=> '',
                            "state"=> 'NSW'
                        ]
                    ]
                ]
            ]
        ];

        return [true, $payment];
    }

    /**
     * sdk/js version
     *
     * @param \Zento\Contracts\Interfaces\Catalog\IShoppingCart $cart
     * @return void
     */
    public function getPaymentData(\Zento\Contracts\Interfaces\Catalog\IShoppingCart $cart) {
        $details = [];
        $details['subtotal'] = $cart->subtotal;

        $items = [];
        foreach($cart->items as $item) {
            $attrs = [];
            $attrs['name'] = $item->name;
            $attrs['description'] = $item->description;
            $attrs['quantity'] = $item->quantity;
            $attrs['price'] = $item->unit_price;
            $attrs['sku'] = $item->product_id;
            $attrs['currency'] = 'AUD';
            $items[] = $attrs;
        }
        $details['shipping'] = $item->shipping_fee;
        // $details['handling'] = $item->handle_fee;
        $shippingaddress = $cart->shipping_address;
        // $shippingCountryCode = $shippingaddress->country;
        $shippingCountryCode = 'AU';

        $payment = [
            // 'intent' => 'sale', //'authorize'
            'payer' => [
                'payer_info' => [
                    'email' => $cart->email
                ]
            ],
            'purchase_units'=> [
                [
                    'amount'=> [
                        'value'=> $cart->total,
                        // 'currency_code'=> "AUD",
                    ],
                ]
            ]
        ];

        return [true, $payment];
    }
}
