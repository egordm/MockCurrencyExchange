<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderFillCreated
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var Order
	 */
	public $order;

	/**
	 * Create a new event instance.
	 *
	 * @param Order $order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		// TODO: lets websock it later on. Either via a vps or this https://habrahabr.ru/post/209864/
		return new PrivateChannel('channel-name');
	}
}
