<?php
namespace App\MoneyKeeper\Helpers;

/**
 *  Number converter helper
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Number {

	/**
	 * Convert value to currency format
	 *
	 * @param float $value value
	 *
	 * @return string
	 */
	public static function curf ($value) {
	    $value *= 100;
	    if ($value%100 == 0) {
	        return round($value/100);
	    }

	    return number_format($value/100, 2, ',', ' ');
	}

}
