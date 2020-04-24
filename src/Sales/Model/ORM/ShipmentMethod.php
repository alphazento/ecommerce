<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class ShipmentMethod extends \Illuminate\Database\Eloquent\Model 
{
    protected $fillable = ['name', 'description'];
}