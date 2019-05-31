<?php 
 /**
  *
  * @package    Base
  * @copyright
  * @license
  * @author      Yongcheng Chen yongcheng.chen@live.com
  */
namespace Zento\Sales\Model;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository as Cache;

class OrderNumberGenerator {
	const CHS_STR = "0123456789ACDEFGHJKLMNPQRSTUVWXYZ";

	/**
	 * The cache store implementation.
	 *
	 * @var \Illuminate\Contracts\Cache\Repository
	 */
	protected $cache;
	protected $key = 'order_number_incr';
	protected $max;

	/**
	 *
	 * @param  \Illuminate\Contracts\Cache\Repository  $cache
	 * @return void
	 */
	public function __construct(Cache $cache, $max = 100000)
	{
			$this->cache = $cache;
			$this->max = $max;
	}

  public function generate($nodeIdx, $prefix = '') {
    if ($nodeIdx > 9) {
      throw new \Exception('Node index bigger than 9');
		}
		$orderNumber = $this->incrOrderNumber();
    $now = Carbon::now();
    $number = sprintf('%d%03d%d%04d', ($now->year-2000), $now->dayOfYear, $nodeIdx, floor($orderNumber / 10));
    $number = sprintf('%s%s%d', $prefix, $this->numToStr($number), $orderNumber % 10);
    return $number;
  }

  public function parser($orderNumber, $withPrefix = false) {
    if ($withPrefix) {
      $orderNumber = substr($orderNumber, 1);
    }

    $len = strlen($orderNumber);
    $encrypted = substr($orderNumber, 0, $len - 1);
    $lastChar = substr($orderNumber, $len - 1, 1);

    $dateAndPartNumber = $this->strToInt($encrypted);
    $year = '20' . substr($dateAndPartNumber, 0, 2);
    $dayOfYear = substr($dateAndPartNumber, 2, 3);
    $nodeIdx = substr($dateAndPartNumber, 5, 1);
    $orderIndex = sprintf('%s%s', substr($dateAndPartNumber, 6), $lastChar);

    $dt = Carbon::create($year, 1, 1, 0);
    $dt->addDays($dayOfYear);
    return sprintf('%s-%s-%s', $nodeIdx, $dt->format('Ymd'), $orderIndex);
	}
	
	protected function incrOrderNumber()
	{
			try {
					$incr = (int) $this->cache->increment($this->key);
					return $incr % $this->max;
			} catch (\Exception $e) {
					$this->cache->put($this->key, 1);
					return 1;
			}
	}
	
	protected function numToStr($number) {
		if ($number < 0) {
			return null;
		}
		$len = strlen(self::CHS_STR);
		$n = -1;
		$intVal = $number;
		$buffer = [];
		do {
			if ($intVal < $len) {
				$n = $intVal;
			} else {
				$n = $intVal % $len;
			}
			$intVal = floor($intVal / $len);
				$buffer[] = substr(self::CHS_STR, $n, 1);
		} while ($intVal > 0);
		return implode('',  array_reverse($buffer));
	}
	
	protected function strToInt($str) {
		$len = strlen(self::CHS_STR);
		$chars = str_split(self::CHS_STR);
		$buffer = str_split(trim($str));
		$digis = array_reverse($buffer);
		$num = 0;
		for ($i = 0, $j=count($digis); $i < $j; $i++) {
				$idx = 0;
				foreach($chars as $char) {
					if ($digis[$i] == $char) {
							break;
					}
					$idx++;
				}
				$num += $idx * pow($len, $i);
		}
		return $num;
  }
  
}
