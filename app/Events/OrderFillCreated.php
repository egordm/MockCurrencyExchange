<?php

namespace App\Events;

use App\Models\Order;
use App\Models\OrderFill;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderFillCreated
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var OrderFill
	 */
	public $orderFill;

	/**
	 * Create a new event instance.
	 *
	 * @param OrderFill $orderFill
	 */
	public function __construct(OrderFill $orderFill)
	{
		$this->orderFill = $orderFill;
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
