<?php

namespace App\Listeners;

use App\Constants\CacheConstants;

class InvalidateOrderBook
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param $event
	 * @return void
	 */
	public function handle($event)
	{
		\Cache::forget(CacheConstants::ORDER_BOOK($event->order->valuta_pair_id));
    }
}
