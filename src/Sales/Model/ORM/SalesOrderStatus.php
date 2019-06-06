<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderStatus extends \Illuminate\Database\Eloquent\Model
{
  const PENDING = 1;
  const CREATED = 1 << 1;
  const PROCESSING = 1 << 2;
  const CONFIRMED = 1 << 3;
  const INVOICED = 1 << 4;
  const CANCELED_BY_CUSTOMER = 1 << 5;
  const CANCELED_BY_VENDOR = 1 << 6;
  const READY_4_DISPATCH = 1 << 7;
  const DELIVERED = 1 << 8;
  const SENT = 1 << 9;
  const LOST = 1 << 10;
  const FULL_REFUNED = 1 << 11;
  const PARTIAL_REFUNED = 1 << 12;
}