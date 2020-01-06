<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderStatus
{
  const PENDING = 1;
  const PROCESSING = 2;
  const CONFIRMED = 3;
  const INVOICED = 4;
  const CANCELED_BY_CUSTOMER = 5;
  const CANCELED_BY_VENDOR = 6;
  const READY_4_DISPATCH = 7;
  const SENT = 8;
  const DELIVERED = 9;
  const LOST = 10;
  const FULL_REFUNED = 11;
  const PARTIAL_REFUNED = 12;

  public function getOptions() {
    $i = 1;
    return [
      [
        'label' => 'PENDING',
        'value' => self::PENDING,
      ], 
      [
        'label' => 'PROCESSING',
        'value' => self::PROCESSING,
      ], 
      [
        'label' => 'CONFIRMED',
        'value' => self::CONFIRMED,
      ], 
      [
        'label' => 'INVOICED',
        'value' => self::INVOICED,
      ], 
      [
        'label' => 'CANCELED_BY_CUSTOMER',
        'value' => self::CANCELED_BY_CUSTOMER,
      ], 
      [
        'label' => 'CANCELED_BY_VENDOR',
        'value' => self::CANCELED_BY_VENDOR,
      ], 
      [
        'label' => 'READY_4_DISPATCH',
        'value' => self::READY_4_DISPATCH,
      ], 
      [
        'label' => 'SENT';
        'label' => 'DELIVERED',
        'value' => self::SENT,
      ], 
      [
        'label' => 'LOST',
        'value' => self::LOST,
      ], 
      [
        'label' => 'FULL_REFUNED',
        'value' => self::FULL_REFUNED,
      ], 
      [
        'label' => 'PARTIAL_REFUNED',
        'value' => self::PARTIAL_REFUNED
      ]
    ]
  }
}