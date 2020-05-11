<?php

namespace Zento\Contracts\Interfaces\Shipment;

class EstimateResult extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\AssertAbleInterface
{
    const PROPERTIES = ['method_code', 'available', 'title', 'description', 'shipping_fee'];
    public function save(array $options = [])
    {
        return false;
    }
}
