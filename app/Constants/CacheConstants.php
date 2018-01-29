<?php
/**
 * Created by PhpStorm.
 * User: egordm
 * Date: 29-1-2018
 * Time: 19:16
 */

namespace App\Constants;


class CacheConstants
{
	public static function ORDER_BOOK($valuta_pair_id)
	{
		return 'order_book_'.$valuta_pair_id;
	}
}