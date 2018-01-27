<?php

namespace App\Listeners;

use App\Events\OrderClosed;
use App\Models\Balance;

class ApplyOrderToBalances
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
	 * @param  OrderClosed $event
	 * @return void
	 * @throws \Illuminate\Support\Facades\ContainerExceptionInterface
	 * @throws \Illuminate\Support\Facades\NotFoundExceptionInterface
	 */
	public function handle(OrderClosed $event)
	{
		$order = $event->order;
		(new Balance(['user_id' => $order->user_id, 'valuta_id' => $order->valuta_pair->valuta_primary_id]))
			->mutate($order->buy ? -$order->filledSellQuantity() : $order->filledBuyQuantity());
		(new Balance(['user_id' => $order->user_id, 'valuta_id' => $order->valuta_pair->valuta_secondary_id]))
			->mutate($order->buy ? $order->filledBuyQuantity() : -$order->filledSellQuantity());
	}
}
