<?php

namespace App\Listeners;

use App\Constants\CacheConstants;
use App\Events\OrderFillCreated;

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
		if($event instanceof OrderFillCreated) {
			\Cache::forget(CacheConstants::ORDER_BOOK($event->orderFill->order_primary->valuta_pair_id));
		}else {
			\Cache::forget(CacheConstants::ORDER_BOOK($event->order->valuta_pair_id));
		}
    }
}
